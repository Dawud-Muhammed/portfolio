@extends('layouts.app')

@section('page_title', 'Dawud Muhammed | Laravel Developer')
@section('meta_description', 'Premium Laravel 13 portfolio with lazy sections, named route navigation, and persistent theme settings.')
@section('hero_name', 'Dawud Muhammed')
@section('hero_title', 'Laravel Developer')
@section('hero_cv_url', '#')
@section('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.')
@section('about_profile_alt', 'Profile portrait of Dawud Muhammed')

@section('content')
    @include('partials.about')

    <main>
        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.skills', ['skills' => $skills])
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-projects :projects="$projects" />
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.testimonials')
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-contact />
        </section>
    </main>
@endsection
