@extends('layouts.app')

@section('page_title', 'Dawud Muhammed | Laravel Developer')
@section('meta_description', 'Hi, I\'m Dawud Muhammed, a Laravel developer building resilient products and premium user experiences.')
@section('hero_name', 'Dawud Muhammed')
@section('hero_title', 'Laravel Developer')
@section('hero_cv_url', '#')
@section('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.')
@section('about_profile_alt', 'Profile portrait of Dawud Muhammed')

@section('content')
    @include('partials.about')
    @include('partials.skills')
    <x-projects />
    <x-contact />
@endsection