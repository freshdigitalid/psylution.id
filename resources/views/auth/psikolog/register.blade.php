<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Daftar Psikolog</h2>
        <p class="text-gray-600">Bergabung sebagai psikolog profesional</p>
    </div>

    <form method="POST" action="{{ route('psikolog.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" placeholder="Contoh: 081234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- License Number -->
        <div class="mt-4">
            <x-input-label for="license_number" :value="__('Nomor Lisensi')" />
            <x-text-input id="license_number" class="block mt-1 w-full" type="text" name="license_number" :value="old('license_number')" required placeholder="Nomor lisensi praktik psikolog" />
            <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
        </div>

        <!-- Specialization -->
        <div class="mt-4">
            <x-input-label for="specialization" :value="__('Spesialisasi')" />
            <x-text-input id="specialization" class="block mt-1 w-full" type="text" name="specialization" :value="old('specialization')" placeholder="Contoh: Psikologi Klinis, Psikologi Anak" />
            <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
        </div>

        <!-- Experience Years -->
        <div class="mt-4">
            <x-input-label for="experience_years" :value="__('Pengalaman (Tahun)')" />
            <x-text-input id="experience_years" class="block mt-1 w-full" type="number" name="experience_years" :value="old('experience_years')" min="0" placeholder="0" />
            <x-input-error :messages="$errors->get('experience_years')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
            <p class="text-sm text-yellow-800">
                <strong>Catatan:</strong> Akun Anda akan diverifikasi oleh admin sebelum dapat digunakan. Pastikan data yang dimasukkan sudah benar.
            </p>
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('psikolog.login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                    {{ __('Sudah punya akun? Login disini') }}
                </a>
                <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-500">
                    ← Kembali ke beranda
                </a>
            </div>
            <x-primary-button class="ml-3">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>