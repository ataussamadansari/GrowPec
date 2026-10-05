<?php

namespace App\Http\Controllers;

use App\Models\LeadershipMessage;
use Illuminate\Contracts\View\View;

class LeadershipMessagePageController extends Controller
{
    public function about(): View
    {
        $leadershipMessages = LeadershipMessage::query()
            ->where('status', true)
            ->orderByRaw("CASE role WHEN 'director' THEN 0 WHEN 'ceo' THEN 1 ELSE 2 END")
            ->get();

        return view('pages.about', compact('leadershipMessages'));
    }

    public function show(LeadershipMessage $leadershipMessage): View
    {
        abort_unless($leadershipMessage->status, 404);

        $leadershipMessages = LeadershipMessage::query()
            ->where('status', true)
            ->orderByRaw("CASE role WHEN 'director' THEN 0 WHEN 'ceo' THEN 1 ELSE 2 END")
            ->get();
        $currentIndex = $leadershipMessages->search(fn (LeadershipMessage $message): bool => $message->is($leadershipMessage));

        return view('pages.leadership-messages.show', [
            'leadershipMessage' => $leadershipMessage,
            'leadershipMessages' => $leadershipMessages,
            'previousLeadershipMessage' => $currentIndex > 0 ? $leadershipMessages->get($currentIndex - 1) : null,
            'nextLeadershipMessage' => $currentIndex !== false && $currentIndex < $leadershipMessages->count() - 1
                ? $leadershipMessages->get($currentIndex + 1)
                : null,
        ]);
    }
}
