@extends('layouts.master-without-nav')
@section('title')
    {{ __('t-verify-email') }}
@endsection
@section('content')
<body
    class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">
    <div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
            <div class="lg:col-span-5 flex items-center">
                <div class="!px-12 !py-12 card-body">

                    <div class="text-center">
                        <h4 class="mb-2 text-purple-500 dark:text-purple-500">Verify Email !</h4>
                        <p class="text-slate-500 dark:text-zink-200">If you didn't receive the email, we will gladly send you another..</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="font-medium text-sm text-green-600 border border-transparent rounded-md bg-green-50 px-4 py-3 mt-4">
                            {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                        </div>
                    @endif
                    <div class="mt-10">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf

                            <div class="text-center">
                                <button type="submit"
                                    class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">{{ __('Resend Verification Email') }}</button>
                            </div>
                        </form>

                        <div class="text-end mt-3">
                            <a href="{{ route('profile.show') }}"
                                class="underline text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Edit Profile') }}</a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf

                                <button type="submit"
                                    class="underline text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
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
