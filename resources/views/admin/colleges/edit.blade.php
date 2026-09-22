@extends('admin.layout')
@section('title', 'Edit College: ' . $college->name . ' - GrowPec Admin')
@section('header', 'Edit College: ' . $college->name)
@section('content')
@if ($errors->any())
<div class="alert alert-danger mb-3" role="alert"><strong>College update nahi hua.</strong>
    <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
<form class="gc-college-form" action="{{ route('admin.colleges.update', $college->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.colleges.college_form')
</form>
@endsection