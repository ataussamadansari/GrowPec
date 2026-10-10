<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\CollegeReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewManagerController extends Controller
{
    /**
     * Display a listing of visitor college reviews with filters and moderation tabs.
     */
    public function index(Request $request): View
    {
        $allCount = CollegeReview::count();
        $pendingCount = CollegeReview::pending()->count();
        $approvedCount = CollegeReview::approved()->count();
        $rejectedCount = CollegeReview::rejected()->count();

        // Default tab to 'pending' unless explicitly specified
        $status = $request->input('status', 'pending');

        $query = CollegeReview::with('college');

        if ($status !== 'all' && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('review', 'like', "%{$search}%")
                    ->orWhereHas('college', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($collegeId = $request->input('college_id')) {
            $query->where('college_id', $collegeId);
        }

        $reviews = $query->latest('id')->paginate(15)->withQueryString();
        $colleges = College::orderBy('name')->get(['id', 'name']);

        return view('admin.reviews.index', compact(
            'reviews',
            'colleges',
            'status',
            'allCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Approve a pending or rejected review and publish it.
     */
    public function approve(CollegeReview $review): RedirectResponse
    {
        $review->update([
            'status' => 'approved',
            'is_verified' => true,
        ]);

        return back()->with('success', 'Review approved successfully and published to the college profile.');
    }

    /**
     * Reject a review.
     */
    public function reject(CollegeReview $review): RedirectResponse
    {
        $review->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Review marked as rejected.');
    }

    /**
     * Permanently delete a review from the database.
     */
    public function destroy(CollegeReview $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Review deleted permanently.');
    }
}
