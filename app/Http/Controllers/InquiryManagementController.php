<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\PublicUser;
use App\Models\AgencyUser;
use App\Models\McmcUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InquiryManagementController extends Controller
{
    /**
     * Show the form for submitting a new inquiry.
     */
    public function showSubmitForm()
    {
        // Check if user is authenticated as public user
        if (!Auth::guard('public')->check()) {
            return redirect('/login')->with('error', 'Please login as a public user to submit an inquiry.');
        }

        return view('manageInquiry.submit');
    }

    /**
     * Submit a new inquiry.
     */
    public function submitInquiry(Request $request)
    {
        // Check if user is authenticated as public user
        if (!Auth::guard('public')->check()) {
            return redirect('/login')->with('error', 'Please login as a public user to submit an inquiry.');
        }

        $request->validate([
            'InquirySubject' => 'required|string|max:255',
            'InquiryCategory' => 'required|string|max:100',
            'InquiryDescription' => 'required|string',
            'InquirySource' => 'required|string|max:100',
            'Attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'InquirySubject' => $request->InquirySubject,
            'InquiryCategory' => $request->InquiryCategory,
            'InquiryDescription' => $request->InquiryDescription,
            'InquirySource' => $request->InquirySource,
            'PublicID' => Auth::guard('public')->id(),
        ];

        // Handle file upload
        if ($request->hasFile('Attachment')) {
            $file = $request->file('Attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('attachments', $filename, 'public');
            $data['Attachment'] = $path;
        }

        $inquiry = Inquiry::create($data);

        return redirect()->route('inquiry.history')->with('success', 'Inquiry submitted successfully!');
    }

    /**
     * View inquiry history for the authenticated user.
     */
    public function viewInquiryHistory()
    {
        // Check if user is authenticated as public user
        if (!Auth::guard('public')->check()) {
            return redirect('/login')->with('error', 'Please login to view your inquiry history.');
        }

        $inquiries = Inquiry::where('PublicID', Auth::guard('public')->id())
                           ->with('publicUser')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('manageInquiry.history', compact('inquiries'));
    }

    /**
     * View filtered inquiries (for MCMC and Agency users).
     */
    public function viewFilteredInquiry(Request $request)
    {
        $user = null;
        $guard = null;

        // Determine which guard is authenticated
        if (Auth::guard('mcmc')->check()) {
            $user = Auth::guard('mcmc')->user();
            $guard = 'mcmc';
        } elseif (Auth::guard('agency')->check()) {
            $user = Auth::guard('agency')->user();
            $guard = 'agency';
        } else {
            return redirect('/login')->with('error', 'Please login to view inquiries.');
        }

        $query = Inquiry::with('publicUser');

        // Apply filters
        if ($request->filled('category')) {
            $query->where('InquiryCategory', $request->category);
        }

        if ($request->filled('source')) {
            $query->where('InquirySource', $request->source);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();

        // Get unique categories and sources for filter options
        $categories = Inquiry::distinct()->pluck('InquiryCategory');
        $sources = Inquiry::distinct()->pluck('InquirySource');

        return view('manageInquiry.filtered', compact('inquiries', 'categories', 'sources', 'guard'));
    }

    /**
     * Generate inquiry report (for MCMC users).
     */
    public function viewInquiryReport(Request $request)
    {
        // Check if user is authenticated as MCMC user
        if (!Auth::guard('mcmc')->check()) {
            return redirect('/login')->with('error', 'Only MCMC users can access reports.');
        }

        $query = Inquiry::with('publicUser');

        // Apply date filters if provided
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->get();

        // Generate statistics
        $stats = [
            'total_inquiries' => $inquiries->count(),
            'by_category' => $inquiries->groupBy('InquiryCategory')->map->count(),
            'by_source' => $inquiries->groupBy('InquirySource')->map->count(),
            'by_month' => $inquiries->groupBy(function($item) {
                return $item->created_at->format('Y-m');
            })->map->count(),
        ];

        return view('manageInquiry.report', compact('inquiries', 'stats'));
    }
}
