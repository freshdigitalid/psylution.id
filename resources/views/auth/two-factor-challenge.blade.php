@extends('layouts.master-without-nav')
@section('title')
    {{ __('t-two-steps') }}
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
                            <h4 class="mb-2 text-custom-500 dark:text-custom-500">Two Step Security</h4>
                        </div>

                        <div x-data="{ recovery: false }">
                            <div class="mb-4 text-sm text-gray-600 dark:text-slate-400" x-show="! recovery">
                                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                            </div>

                            <div class="mb-4 text-sm text-gray-600 dark:text-slate-400" x-cloak x-show="recovery">
                                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                            </div>

                            <x-validation-errors class="mb-4" />

                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf

                                <div class="mt-4" x-show="! recovery">
                                    <x-label for="code" value="{{ __('Code') }}" />
                                    <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric"
                                        name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                                </div>

                                <div class="mt-4" x-cloak x-show="recovery">
                                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                                    <x-input id="recovery_code" class="block mt-1 w-full" type="text"
                                        name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="button"
                                        class="text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 underline cursor-pointer"
                                        x-show="! recovery"
                                        x-on:click="
                                                    recovery = true;
                                                    $nextTick(() => { $refs.recovery_code.focus() })
                                                ">
                                        {{ __('Use a recovery code') }}
                                    </button>

                                    <button type="button"
                                        class="text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 underline cursor-pointer" x-cloak
                                        x-show="recovery"
                                        x-on:click="
                                                    recovery = false;
                                                    $nextTick(() => { $refs.code.focus() })
                                                ">
                                        {{ __('Use an authentication code') }}
                                    </button>

                                    <x-button class="ms-4" variant="green">
                                        {{ __('Log in') }}
                                    </x-button>
                                </div>
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
