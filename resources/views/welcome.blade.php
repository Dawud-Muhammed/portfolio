@extends('layouts.app')

@section('page_title', $siteSettings['page_title'])
@section('meta_description', $siteSettings['meta_description'])
@section('hero_name', $siteSettings['hero_name'])
@section('hero_title', $siteSettings['hero_title'])
@section('hero_cv_url', $siteSettings['hero_cv_url'])
@section('hero_cta_label', $siteSettings['hero_cta_label'])
@section('hero_primary_cta_label', $siteSettings['hero_primary_cta_label'])
@section('hero_availability_text', $siteSettings['hero_availability_text'])
@section('hero_description', $siteSettings['hero_description'])
@section('hero_background', $siteSettings['hero_background'])
@section('hero_background_alt', $siteSettings['hero_background_alt'])
@section('brand_name', $siteSettings['brand_name'])
@section('about_badge', $siteSettings['about_badge'])
@section('about_heading', $siteSettings['about_heading'])
@section('about_bio', $siteSettings['about_bio'])
@section('about_profile_image', $siteSettings['about_profile_image'])
@section('about_profile_alt', $siteSettings['about_profile_alt'])

@section('content')
    @include('partials.inline-header', ['navigationLinks' => $navigationLinks])

    @include('partials.about', ['aboutSkills' => $aboutSkills])

    <main>
        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.skills', [
                'skills' => $skills,
                'kicker' => $siteSettings['skills_badge'],
                'heading' => $siteSettings['skills_heading'],
                'subheading' => $siteSettings['skills_subheading'],
            ])
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-projects
                :projects="$projects"
                :categories="$projectCategories"
                :kicker="$siteSettings['projects_badge']"
                :heading="$siteSettings['projects_heading']"
            />
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            @include('partials.testimonials', [
                'testimonials' => $testimonials,
                'kicker' => $siteSettings['testimonials_badge'],
                'heading' => $siteSettings['testimonials_heading'],
                'subheading' => $siteSettings['testimonials_subheading'],
            ])
        </section>

        <section class="mx-auto w-full max-w-7xl px-6">
            <x-contact
                :kicker="$siteSettings['contact_badge']"
                :heading="$siteSettings['contact_heading']"
                :subheading="$siteSettings['contact_subheading']"
                :submit-label="$siteSettings['contact_submit_label']"
                :submitting-label="$siteSettings['contact_submitting_label']"
                :name-label="$siteSettings['contact_name_label']"
                :email-label="$siteSettings['contact_email_label']"
                :subject-label="$siteSettings['contact_subject_label']"
                :message-label="$siteSettings['contact_message_label']"
                :validation-error-message="$siteSettings['contact_validation_error']"
                :success-message="$siteSettings['contact_success_message']"
                :error-message="$siteSettings['contact_error_message']"
                :network-error-message="$siteSettings['contact_network_error']"
            />
        </section>
    </main>
@endsection
