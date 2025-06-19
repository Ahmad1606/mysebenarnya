<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquiry;
use App\Models\InquiryProgress;
use PDF;
use Excel;

class InquiryManagementController extends Controller
{
    // ------------------------------
    // PUBLIC USER METHODS
    // ------------------------------

    // Show inquiry submission form
    public function showSubmitForm()
    {
        $categories = [
            ['CategoryID' => 1, 'CategoryName' => 'Scam'],
            ['CategoryID' => 2, 'CategoryName' => 'False Information'],
            ['CategoryID' => 3, 'CategoryName' => 'Cyberbullying'],
            ['CategoryID' => 4, 'CategoryName' => 'Misinformation'],
            ['CategoryID' => 5, 'CategoryName' => 'Others'],
        ];

        return view('manageInquiry.SubmitInquiryForm', compact('categories'));
}


    // 1. Submit Inquiry (Public)
    public function submitInquiry(Request $request)
    {
        $request->validate([
            'InquiryTitle' => 'required|string|max:255',
            'InquiryDescription' => 'required|string',
            'InquiryCategory' => 'required|in:Scam,False Information,Cyberbullying,Misinformation,Others',
            'InquirySource' => 'required|string',
            'Evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);

        $evidencePaths = [];

        if ($request->hasFile('Evidence')) {
            foreach ($request->file('Evidence') as $file) {
                $evidencePaths[] = $file->store('evidence', 'public');
            }
        }

        $inquiry = new \App\Models\Inquiry([
            'InquirySubject' => $request->InquiryTitle,
            'InquiryDescription' => $request->InquiryDescription,
            'InquiryCategory' => $request->InquiryCategory,
            'InquirySource' => $request->InquirySource,
            'Attachment' => json_encode($evidencePaths),
            'PublicID' => Auth::guard('public')->user()->PublicID,
        ]);

        $inquiry->save();

        // Log initial progress if needed
        $data = [
            'InquiryID' => $inquiry->InquiryID,
            'ProgressStatus' => 'Submitted',
            'ProgressDescription' => 'Inquiry submitted by user',
            'ProgressDate' => now(),
        ];

        return redirect()->route('public.inquiry')->with('success', 'Inquiry submitted successfully.');
}


    // 2. View Past Inquiries (Public)
    public function viewMyInquiries()
    {
    
        $user = Auth::guard('public')->user();
        $inquiries = Inquiry::where('PublicID', $user->PublicID)
            ->with(['progress'])
            ->orderBy('created_at', 'desc')
            ->get();   

        return view('manageInquiry.ViewInquiryHistory', compact('inquiries'));
    }

    // 3. View Public Inquiries (Public)
    public function viewPublicInquiries()
    {
        $inquiries = Inquiry::with(['publicUser'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('manageInquiry.ViewInquiryReport', compact('inquiries'));
}

    // ------------------------------
    // MCMC METHODS
    // ------------------------------

    // 4. View New Inquiries (MCMC)
    public function viewNewInquiries()
    {
        $inquiries = Inquiry::where('InquiryStatus', 'Submitted')
            ->with(['publicUser'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('manageInquiry.ViewFilteredInquiry', [
            'inquiries' => $inquiries,
            'title' => 'New Inquiries',
            'filterType' => 'new'
        ]);
    }

    // 5. Filter/Validate Inquiry (MCMC)
    public function validateInquiry(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Validated,Rejected',
            'remarks' => 'nullable|string',
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->InquiryStatus = $request->status;
        $inquiry->MCMCRemarks = $request->remarks;
        $inquiry->MCMCID = Auth::guard('mcmc')->user()->MCMCID;
        $inquiry->save();

        // Add progress entry
        InquiryProgress::create([
            'InquiryID' => $inquiry->InquiryID,
            'ProgressStatus' => $request->status,
            'ProgressDescription' => 'Inquiry ' . strtolower($request->status) . ' by MCMC. ' . $request->remarks,
            'ProgressDate' => now()
        ]);

        return redirect()->back()->with('success', 'Inquiry ' . strtolower($request->status) . ' successfully.');
    }

    // 6. View Filtered Inquiries (MCMC)
    public function viewFilteredInquiries(Request $request)
    {
        $query = Inquiry::with(['publicUser', 'agencyUser']);

        if ($request->filled('status')) {
            $query->where('InquiryStatus', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('CategoryID', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        
        return view('manageInquiry.ViewFilteredInquiry', [
            'inquiries' => $inquiries,
            'categories' => $categories,
            'title' => 'Filtered Inquiries',
            'filterType' => 'custom',
            'filters' => $request->all()
        ]);
    }

    // 7. Generate Report (MCMC)
    public function generateReport(Request $request)
    {
        $query = Inquiry::with(['publicUser', 'agencyUser', 'mcmcUser']);

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('InquiryStatus', $request->status);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();
        
        // Handle export formats
        if ($request->has('export')) {
            try {
                if ($request->export === 'pdf') {
                    $pdf = PDF::loadView('manageInquiry.pdf.inquiry_report', compact('inquiries'));
                    return $pdf->download('inquiry_report.pdf');
                } elseif ($request->export === 'excel') {
                    return Excel::download(new \App\Exports\InquiryExport($inquiries), 'inquiry_report.xlsx');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Export failed: ' . $e->getMessage());
            }
        }

        return view('manageInquiry.ViewInquiryReport', [
            'inquiries' => $inquiries,
            'months' => $this->getMonthsArray(),
            'years' => $this->getYearsArray(),
            'filters' => $request->all()
        ]);
    }

    // ------------------------------
    // AGENCY METHODS
    // ------------------------------

    // 8. View Assigned Inquiries (Agency)
    public function viewAssignedInquiries()
    {
        $user = Auth::guard('agency')->user();
        $inquiries = Inquiry::where('AgencyID', $user->AgencyID)
            ->with(['category', 'publicUser', 'progress'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('manageInquiry.ViewFilteredInquiry', [
            'inquiries' => $inquiries,
            'title' => 'Assigned Inquiries',
            'filterType' => 'agency'
        ]);
    }

    // 9. Filter Assigned Inquiries (Agency)
    public function filterAssignedInquiries(Request $request)
    {
        $user = Auth::guard('agency')->user();
        $query = Inquiry::where('AgencyID', $user->AgencyID)
            ->with(['category', 'publicUser', 'progress']);

        if ($request->filled('status')) {
            $query->where('InquiryStatus', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('CategoryID', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        
        return view('manageInquiry.ViewFilteredInquiry', [
            'inquiries' => $inquiries,
            'categories' => $categories,
            'title' => 'Filtered Inquiries',
            'filterType' => 'agency_filtered',
            'filters' => $request->all()
        ]);
    }

    // 10. Track Inquiry History (Agency)
    public function trackInquiryHistory($id)
    {
        $inquiry = Inquiry::with(['publicUser', 'agencyUser', 'mcmcUser'])
            ->findOrFail($id);
            
        $progress = InquiryProgress::where('InquiryID', $id)
            ->orderBy('ProgressDate', 'desc')
            ->get();
            
        return view('manageInquiry.ViewInquiryHistory', [
            'inquiry' => $inquiry,
            'progress' => $progress
        ]);
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
