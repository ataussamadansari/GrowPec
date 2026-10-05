<div>
    <!-- We must ship. - Taylor Otwell -->
</div>
@extends('admin.layout')

@section('title', 'Add Leadership Message - GrowPec Admin')
@section('header', 'Add Leadership Message')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-3 p-md-4">
    <div class="mb-3">
        <h2 class="h5 fw-bold text-primary mb-1">New leadership profile</h2>
        <p class="text-muted small mb-0">Add the Director or CEO message. It will show publicly only after you publish it.</p>
    </div>
    @include('admin.leadership-messages._form', [
        'action' => route('admin.leadership-messages.store'),
        'method' => 'POST',
        'leadershipMessage' => null,
    ])
</div>
@endsection
