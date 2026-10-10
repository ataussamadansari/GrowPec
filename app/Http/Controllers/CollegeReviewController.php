<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollegeReviewRequest;
use App\Models\College;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CollegeReviewController extends Controller
{
    /**
     * Store a guest visitor review for a college.
     */
    public function store(StoreCollegeReviewRequest $request, string $slug): JsonResponse|RedirectResponse
    {
        $college = College::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $course = $request->courseName();

        $review = $college->reviews()->create([
            'reviewer_name' => strip_tags((string) $request->validated('reviewer_name')),
            'email' => strtolower(trim((string) $request->validated('email'))),
            'course' => $course ? strip_tags((string) $course) : null,
            'rating' => (int) $request->validated('rating'),
            'review' => strip_tags($request->reviewBody()),
            'ip_address' => $request->ip(),
            'status' => 'pending',
            'is_verified' => false,
        ]);

        $message = 'Thank you! Your review has been submitted and is awaiting administrator moderation.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $review->id,
                    'college_id' => $college->id,
                    'reviewer_name' => $review->reviewer_name,
                    'rating' => $review->rating,
                    'status' => $review->status,
                ],
            ], 201);
        }

        return back()->with('review_success', $message);
    }
}
