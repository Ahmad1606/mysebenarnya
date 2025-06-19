<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\InquiryProgress;
use App\Models\AgencyUser;
use App\Models\Jurisdiction;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;

class AssignmentManagementController extends Controller
{
    // ----------------------------
    // PUBLIC USER METHODS
    // ----------------------------

    // 1. View Assigned Agency (Public)
    public function viewAssignedAgency()
    {
        $user = Auth::guard('public')->user();
        $inquiries = Inquiry::where('PublicID', $user->PublicID)
            ->whereNotNull('AgencyID')
            ->with(['agencyUser', 'category'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('manageAssign.AssignAgencyForm', [
            'inquiries' => $inquiries,
            'userType' => 'public'
        ]);
    }

    // ----------------------------
    // MCMC STAFF METHODS
    // ----------------------------

    // 2. View Unassigned Validated Inquiries (MCMC)
    public function listUnassignedInquiries()
    {
        $inquiries = Inquiry::whereNull('AgencyID')
            ->where('InquiryStatus', 'Validated')
            ->with(['publicUser', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();

        $agencies = AgencyUser::all();
        $jurisdictions = Jurisdiction::all();
        
        return view('manageAssign.AssignAgencyForm', [
            'inquiries' => $inquiries,
            'agencies' => $agencies,
            'jurisdictions' => $jurisdictions,
            'userType' => 'mcmc'
        ]);
    }

    // 3. Assign Inquiry to Agency (MCMC)
    public function assignToAgency(Request $request, $id)
    {
        $request->validate([
            'AgencyID' => 'required|exists:agency_users,AgencyID',
            'JurisdictionID' => 'required|exists:jurisdictions,JurisdictionID',
            'AssignmentRemarks' => 'nullable|string|max:255',
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->AgencyID = $request->AgencyID;
        $inquiry->JurisdictionID = $request->JurisdictionID;
        $inquiry->AssignmentRemarks = $request->AssignmentRemarks;
        $inquiry->AssignmentDate = now();
        $inquiry->InquiryStatus = 'Assigned';
        $inquiry->save();

        // Create progress entry
        InquiryProgress::create([
            'InquiryID' => $inquiry->InquiryID,
            'ProgressStatus' => 'Assigned',
            'ProgressDescription' => 'Assigned to agency by MCMC. ' . $request->AssignmentRemarks,
            'ProgressDate' => now()
        ]);

        return redirect()->route('mcmc.inquiries.list')->with('success', 'Inquiry assigned successfully.');
    }

    // 4. Generate Assignment Report (MCMC)
    public function viewAssignReport(Request $request)
    {
        $query = Inquiry::with(['agencyUser', 'publicUser', 'category', 'jurisdiction']);

        if ($request->filled('month')) {
            $query->whereMonth('AssignmentDate', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('AssignmentDate', $request->year);
        }

        if ($request->filled('AgencyID')) {
            $query->where('AgencyID', $request->AgencyID);
        }

        if ($request->filled('status')) {
            $query->where('InquiryStatus', $request->status);
        }

        $inquiries = $query->whereNotNull('AgencyID')->orderBy('AssignmentDate', 'desc')->get();
        $agencies = AgencyUser::all();
        
        // Handle export formats
        if ($request->has('export')) {
            try {
                if ($request->export === 'pdf') {
                    $pdf = PDF::loadView('manageAssign.pdf.assignment_report', [
                        'inquiries' => $inquiries,
                        'filters' => $request->all()
                    ]);
                    return $pdf->download('assignment_report.pdf');
                } elseif ($request->export === 'excel') {
                    return Excel::download(new \App\Exports\AssignmentExport($inquiries), 'assignment_report.xlsx');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Export failed: ' . $e->getMessage());
            }
        }

        return view('manageAssign.ViewAssignReport', [
            'inquiries' => $inquiries,
            'agencies' => $agencies,
            'months' => $this->getMonthsArray(),
            'years' => $this->getYearsArray(),
            'filters' => $request->all()
        ]);
    }
    
    // 5. Show Jurisdiction Form (MCMC)
    public function showJurisdictionForm()
    {
        $jurisdictions = Jurisdiction::all();
        return view('manageAssign.JurisdictionForm', compact('jurisdictions'));
    }

    // 6. Add/Edit Jurisdiction (MCMC)
    public function manageJurisdiction(Request $request)
    {
        $request->validate([
            'JurisdictionName' => 'required|string|max:255',
            'JurisdictionDescription' => 'required|string',
        ]);

        if ($request->has('JurisdictionID')) {
            // Update existing
            $jurisdiction = Jurisdiction::findOrFail($request->JurisdictionID);
            $jurisdiction->JurisdictionName = $request->JurisdictionName;
            $jurisdiction->JurisdictionDescription = $request->JurisdictionDescription;
            $jurisdiction->save();
            $message = 'Jurisdiction updated successfully.';
        } else {
            // Create new
            Jurisdiction::create([
                'JurisdictionName' => $request->JurisdictionName,
                'JurisdictionDescription' => $request->JurisdictionDescription,
            ]);
            $message = 'Jurisdiction added successfully.';
        }

        return redirect()->route('mcmc.jurisdictions')->with('success', $message);
    }

    // ----------------------------
    // AGENCY METHODS
    // ----------------------------

    // 7. View Assigned Inquiries (Agency)
    public function viewAgencyAssignedInquiries()
    {
        $agency = Auth::guard('agency')->user();
        $inquiries = Inquiry::where('AgencyID', $agency->AgencyID)
            ->with(['publicUser', 'category', 'jurisdiction'])
            ->orderBy('AssignmentDate', 'desc')
            ->get();

        return view('manageAssign.AssignAgencyForm', [
            'inquiries' => $inquiries,
            'userType' => 'agency'
        ]);
    }

    // 8. Reject Inquiry with Reason (Agency)
    public function rejectInquiry(Request $request, $id)
    {
        $request->validate([
            'RejectionReason' => 'required|string|max:255',
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $oldAgencyID = $inquiry->AgencyID;
        $inquiry->InquiryStatus = 'Rejected';
        $inquiry->RejectionReason = $request->RejectionReason;
        $inquiry->RejectionDate = now();
        $inquiry->save();

        // Create progress entry
        InquiryProgress::create([
            'InquiryID' => $inquiry->InquiryID,
            'ProgressStatus' => 'Rejected',
            'ProgressDescription' => 'Rejected by agency. Reason: ' . $request->RejectionReason,
            'ProgressDate' => now()
        ]);

        return redirect()->route('agency.inquiries.view')->with('info', 'Inquiry rejected and sent back to MCMC.');
    }

    // 9. Show Rejection Form (Agency)
    public function showRejectionForm($id)
    {
        $inquiry = Inquiry::with(['publicUser'])->findOrFail($id);
        
        // Ensure agency can only reject their own inquiries
        if ($inquiry->AgencyID != Auth::guard('agency')->user()->AgencyID) {
            return redirect()->route('agency.inquiries.view')->with('error', 'Unauthorized access.');
        }
        
        return view('manageAssign.RejectionForm', compact('inquiry'));
    }
    
    // Helper methods
    private function getMonthsArray()
    {
        return [
            1 => 'January', 2 => 'February', 3 => 'March', 
            4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September',
            10 => 'October', 11 => 'November', 12 => 'December'
        ];
    }
    
    private function getYearsArray()
    {
        $currentYear = date('Y');
        $years = [];
        for ($i = $currentYear - 2; $i <= $currentYear; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }
}
