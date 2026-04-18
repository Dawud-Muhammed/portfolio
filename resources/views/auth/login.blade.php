@extends('layouts.app')

@section('page_title', 'Admin Login')
@section('meta_description', 'Secure login for portfolio administration.')
@section('hero_name', 'Secure Access')
@section('hero_title', 'Admin Portal Login')
@section('hero_cv_url', route('home'))

@section('content')
    <main class="mx-auto w-full max-w-md px-6 pb-20 pt-10">
        <section class="rounded-3xl border border-slate-200/80 bg-white/85 p-8 shadow-premium backdrop-blur-sm">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                Sign In
            </h1>
            <p class="mt-2 text-sm text-slate-600" style="font-family: var(--font-body);">
                Use your account credentials to access the admin area.
            </p>

            <form action="{{ route('login.store') }}" method="POST" class="mt-8 space-y-5" novalidate>
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-600">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('email')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-600">Password</label>
                    <input id="password" name="password" type="password" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('password')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-300">
                    Remember me
                </label>

                <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-5 py-3 text-sm font-semibold uppercase tracking-[0.14em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
                    Login
                </button>
            </form>
        </section>
    </main>
@endsection
