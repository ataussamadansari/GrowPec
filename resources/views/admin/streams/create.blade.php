@extends('admin.layout')
@section('title', 'Add New Stream - GrowPec Admin')
@section('header', 'Add New Stream')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.streams.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Stream Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Engineering & Technology, Management, Pharmacy" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">Save Stream</button>
                    <a href="{{ route('admin.streams.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection