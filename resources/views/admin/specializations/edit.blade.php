@extends('admin.layout')

@section('title', 'Edit Specialization: ' . ($specialization->name ?? 'Specialization') . ' - GrowPec Admin')
@section('header', 'Edit Specialization')

@section('content')
@include('admin.specializations.specialization_form')
@endsection