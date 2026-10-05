<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadershipMessageController extends Controller
{
    public function index(): View
    {
        $messages = LeadershipMessage::query()
            ->orderByRaw("CASE role WHEN 'director' THEN 0 WHEN 'ceo' THEN 1 ELSE 2 END")
            ->get();

        return view('admin.leadership-messages.index', compact('messages'));
    }

    public function create(): View
    {
        return view('admin.leadership-messages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:director,ceo', 'unique:leadership_messages,role'],
            'name' => ['required', 'string', 'max:150'],
            'designation' => ['required', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'message' => ['required', 'string', 'max:5000'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('leadership', 'public');
        }

        LeadershipMessage::create($validated);

        return redirect()->route('admin.leadership-messages.index')->with('success', 'Leadership message created successfully.');
    }

    public function edit(LeadershipMessage $leadershipMessage): View
    {
        return view('admin.leadership-messages.edit', compact('leadershipMessage'));
    }

    public function update(Request $request, LeadershipMessage $leadershipMessage): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:director,ceo', 'unique:leadership_messages,role,'.$leadershipMessage->id],
            'name' => ['required', 'string', 'max:150'],
            'designation' => ['required', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'message' => ['required', 'string', 'max:5000'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('photo')) {
            $newPhoto = $request->file('photo')->store('leadership', 'public');

            if ($leadershipMessage->photo && Storage::disk('public')->exists($leadershipMessage->photo)) {
                Storage::disk('public')->delete($leadershipMessage->photo);
            }

            $validated['photo'] = $newPhoto;
        } else {
            unset($validated['photo']);
        }

        $leadershipMessage->update($validated);

        return redirect()->route('admin.leadership-messages.index')->with('success', 'Leadership message updated successfully.');
    }

    public function destroy(LeadershipMessage $leadershipMessage): RedirectResponse
    {
        if ($leadershipMessage->photo && Storage::disk('public')->exists($leadershipMessage->photo)) {
            Storage::disk('public')->delete($leadershipMessage->photo);
        }

        $leadershipMessage->delete();

        return redirect()->route('admin.leadership-messages.index')->with('success', 'Leadership message removed.');
    }
}
