@extends('admin.layout')

@section('title', 'Add New College — GrowPec Admin')
@section('header', 'Add New College')

@section('content')

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4"
         style="border-radius:12px;font-size:.76rem;" role="alert">
        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form class="cf-college-form"
      action="{{ route('admin.colleges.store') }}"
      method="POST"
      enctype="multipart/form-data"
      novalidate>
    @csrf
    @include('admin.colleges.college_form')
</form>

@endsection
