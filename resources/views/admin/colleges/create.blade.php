@extends('admin.layout')
@section('title', 'Add New College - GrowPec Admin')
@section('header', 'Add New College')
@section('content')
@if ($errors->any())
<div class="alert alert-danger mb-3" role="alert"><strong>College save nahi hua.</strong>
    <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
<form class="gc-college-form" action="{{ route('admin.colleges.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.colleges.college_form')
</form>
@endsection