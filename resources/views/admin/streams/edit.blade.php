@extends('admin.layout')

@section('title', 'Edit Stream: ' . ($stream->name ?? 'Stream') . ' - GrowPec Admin')
@section('header', 'Edit Stream: ' . ($stream->name ?? 'Stream'))

@section('content')
@include('admin.streams.stream_form')
@endsection