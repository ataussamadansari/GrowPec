<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebsiteReviewRequest;
use App\Models\WebsiteReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class WebsiteReviewController extends Controller
{
    /**
     * Store a guest visitor review for the GrowPec website.
     */
    public function store(StoreWebsiteReviewRequest $request): JsonResponse|RedirectResponse
    {
        $review = WebsiteReview::create([
            'reviewer_name' => strip_tags((string) $request->validated('reviewer_name')),
            'email' => strtolower(trim((string) $request->validated('email'))),
            'rating' => (int) $request->validated('rating'),
            'title' => $request->filled('title') ? strip_tags((string) $request->validated('title')) : null,
            'review' => strip_tags((string) $request->validated('review')),
            'ip_address' => $request->ip(),
            'status' => 'pending',
            'is_featured' => false,
        ]);

        $message = 'Thank you! Your review has been submitted and is awaiting administrator moderation.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $review->id,
                    'reviewer_name' => $review->reviewer_name,
                    'rating' => $review->rating,
                    'status' => $review->status,
                ],
            ], 201);
        }

        return back()->with('website_review_success', $message);
    }
}
