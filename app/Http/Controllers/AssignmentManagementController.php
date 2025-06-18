<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inquiry;
use App\Models\InquiryProgress;
use App\Models\AgencyUser;

class AssignmentManagementController extends Controller
{
    // Assign inquiry to agency
    public function assignAgency(Request $request)
    {
        $request->validate([
            'InquiryID' => 'required|exists:inquiries,InquiryID',
            'AgencyID' => 'required|exists:agency_users,AgencyID',
        ]);

        $assignment = InquiryProgress::create([
            'Inquiry_Id' => $request->InquiryID,
            'Agency_Id' => $request->AgencyID,
            'Assigned_by' => Auth::guard('mcmc')->id(),
            'Assigned_at' => now(),
        ]);

        Inquiry::where('InquiryID', $request->InquiryID)->update([
            'status' => 'Assigned'
        ]);

        return redirect()->back()->with('success', 'Inquiry assigned successfully.');
    }

    // View assignment reports
    public function viewAssignmentReport(Request $request)
    {
        $assignments = InquiryProgress::with('agency', 'inquiry')
            ->when($request->agency, fn($q) => $q->where('Agency_Id', $request->agency))
            ->when($request->start_date, fn($q) => $q->whereDate('Assigned_at', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('Assigned_at', '<=', $request->end_date))
            ->get();

        return view('assignments.report', compact('assignments'));
    }

    // Reject inquiry
    public function rejectInquiry(Request $request)
    {
        $request->validate([
            'InquiryID' => 'required|exists:inquiries,InquiryID',
            'RejectionReason' => 'required|string',
        ]);

        Inquiry::where('InquiryID', $request->InquiryID)->update([
            'status' => 'Rejected'
        ]);

        return redirect()->back()->with('message', 'Inquiry marked as rejected.');
    }

    // Get agency jurisdiction (dummy for now)
    public function getJurisdiction()
    {
        $agencies = AgencyUser::select('AgencyID', 'AgencyUserName', 'AgencyContact')->get();
        return view('assignments.jurisdiction', compact('agencies'));
    }
}