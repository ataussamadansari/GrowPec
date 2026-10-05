@extends('admin.layout')

@section('title', 'Edit Partner: ' . $partner->name . ' - GrowPec Admin')

@section('header', 'Edit Partner University')

@section('content')
    @include('admin.partners.partner_form')
@endsection
