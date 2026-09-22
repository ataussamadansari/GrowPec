@extends('admin.layout')

@section('title', 'Edit Course - GrowPec Admin')

@section('header', 'Edit Course: ' . $course->name)

@section('content')
@include('admin.courses.course_form')
@endsection