@extends('layouts.master-without-nav')
@section('title')
    {{ __('Forget Password') }}
@endsection
@section('content')
<body
    class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">
    <div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <div class="!px-12 !py-12 card-body h-full flex flex-col">

                    <div class="my-auto">
                        <div class="text-center">
                            <h4 class="mb-2 text-custom-500 dark:text-custom-500">Forgot Password?</h4>
                            <p class="mb-8 text-slate-500 dark:text-zink-200">Reset your Tailwick password</p>
                        </div>

                        <div
                            class="px-4 py-3 mb-6 text-sm text-yellow-500 border border-transparent rounded-md bg-yellow-50 dark:bg-yellow-400/20">
                            Provide your email address, and instructions will be sent to you
                        </div>

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600 border border-transparent rounded-md bg-green-50 px-4 py-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your registered email" />
                                <x-input-error for="email" />
                            </div>
                            <div class="mt-8">
                                <button type="submit"
                                    class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Send
                                    Reset Link</button>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="mb-0">Wait, I remember my password... <a href="{{ route('login') }}"
                                        class="underline fw-medium text-custom-500"> Click here </a> </p>
                            </div>
                        </form>
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
