@extends('layouts.app')

@section('page_title', 'Dawud Muhammed | Laravel Developer')
@section('meta_description', 'Premium Laravel 13 portfolio with lazy sections, named route navigation, and persistent theme settings.')
@section('hero_name', $siteSettings['hero_name'])
@section('hero_title', $siteSettings['hero_title'])
@section('hero_cv_url', $siteSettings['hero_cv_url'])
@section('hero_background', $siteSettings['hero_background'])
@section('about_bio', $siteSettings['about_bio'])
@section('about_profile_image', $siteSettings['about_profile_image'])
@section('about_profile_alt', 'Profile portrait of Dawud Muhammed')

@section('content')
    @include('partials.inline-header')

    @include('partials.about')

    <main>
        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.skills', ['skills' => $skills])
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-projects :projects="$projects" :categories="$projectCategories" />
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.testimonials', ['testimonials' => $testimonials])
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-contact />
        </section>
    </main>
@endsection
