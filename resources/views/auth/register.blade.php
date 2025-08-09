@extends('layouts.master-without-nav')
@section('title')
    {{ __('t-register') }}
@endsection
@section('content')
<body
    class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">
    <div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <div class="!px-10 !py-12 card-body">

                    <div class="text-center">
                        <h4 class="mb-2 text-purple-500 dark:text-purple-500">Welcome !</h4>
                        <p class="text-slate-500 dark:text-zink-200">Sign Up to continue to Tailwick.</p>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('register') }}" class="mt-10">
                            @csrf
                            <div class="mb-3">
                                <x-label for="name" value="{{ __('Name') }}" />
                                <x-input id="name" type="text" name="name" :value="old('name')" required autofocus
                                    autocomplete="name" placeholder="Enter name" />
                                <x-input-error for="name" />
                            </div>
                            <div class="mb-3">
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" type="email" name="email" :value="old('email')" required
                                    autocomplete="username" placeholder="Enter valid email" />
                                <x-input-error for="email" />
                            </div>
                            <div class="mb-3">
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" type="password" name="password" required autocomplete="new-password"
                                    placeholder="Enter password" />
                                <x-input-error for="password" />
                            </div>
                            <div class="mb-3">
                                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                <x-input id="password_confirmation" type="password" name="password_confirmation" required
                                    autocomplete="new-password" placeholder="Enter confirm password" />
                            </div>
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="mt-4">
                                    <label for="terms">
                                        <div class="flex items-center">
                                            <x-checkbox name="terms" id="terms" required />

                                            <div class="ms-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' =>
                                                        '<a target="_blank" href="' .
                                                        route('terms.show') .
                                                        '" class="underline text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Terms of Service') .
                                                        '</a>',
                                                    'privacy_policy' =>
                                                        '<a target="_blank" href="' .
                                                        route('policy.show') .
                                                        '" class="underline text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Privacy Policy') .
                                                        '</a>',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endif
                            <div class="mt-5">
                                <button type="submit"
                                    class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Sign
                                    In</button>
                            </div>
                        </form>
                        <div
                            class="relative text-center my-9 before:absolute before:top-3 before:left-0 before:right-0 before:border-t before:border-t-slate-200 dark:before:border-t-zink-500">
                            <h5
                                class="inline-block px-4 py-0.5 text-sm bg-white text-slate-500 dark:bg-zink-700 dark:text-zink-200 rounded relative">
                                Create account with</h5>
                        </div>

                        <x-social-login />

                        <div class="mt-10 text-center">
                            <p class="mb-0 text-slate-500 dark:text-zink-200">Already have an account ? <a
                                    href="{{ route('login') }}"
                                    class="font-semibold underline transition-all duration-150 ease-linear text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500">Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 card bg-white/60 dark:bg-zink-500/60">
                <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">
                    <div class="flex items-center justify-between gap-3">
                        <div class="grow">
                            <a href="{{ url('index') }}">
                                <x-application-logo />
                            </a>
                        </div>
                        <div class="shrink-0">
                            <x-language />
                        </div>
                    </div>
                    <div class="mt-auto">
                        <img src="{{ URL::asset('build/images/auth/img-01.png') }}" alt=""
                            class="md:max-w-[32rem] mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
