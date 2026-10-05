<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
</div>
@extends('admin.layout')

@section('title', 'Edit Leadership Message - GrowPec Admin')
@section('header', 'Edit Leadership Message')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-3 p-md-4">
    <div class="mb-3">
        <h2 class="h5 fw-bold text-primary mb-1">Update {{ ucfirst($leadershipMessage->role) }} profile</h2>
        <p class="text-muted small mb-0">Edit the public message, portrait or visibility.</p>
    </div>
    @include('admin.leadership-messages._form', [
        'action' => route('admin.leadership-messages.update', $leadershipMessage),
        'method' => 'PUT',
        'leadershipMessage' => $leadershipMessage,
    ])
</div>
@endsection
