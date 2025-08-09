<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Psikolog Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat datang, {{ Auth::guard('psikolog')->user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Sesi</h4>
                            <p class="text-2xl font-bold text-blue-600">0</p>
                        </div>
                        
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-green-800">Pasien Aktif</h4>
                            <p class="text-2xl font-bold text-green-600">0</p>
                        </div>
                        
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Pendapatan</h4>
                            <p class="text-2xl font-bold text-purple-600">Rp 0</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold mb-4">Informasi Profil</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p><strong>Nama:</strong> {{ Auth::guard('psikolog')->user()->name }}</p>
                            <p><strong>Email:</strong> {{ Auth::guard('psikolog')->user()->email }}</p>
                            <p><strong>Nomor Lisensi:</strong> {{ Auth::guard('psikolog')->user()->license_number }}</p>
                            <p><strong>Spesialisasi:</strong> {{ Auth::guard('psikolog')->user()->specialization ?: 'Belum diisi' }}</p>
                            <p><strong>Pengalaman:</strong> {{ Auth::guard('psikolog')->user()->experience_years }} tahun</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold mb-4">Aksi Cepat</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Kelola Jadwal
                            </a>
                            <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Lihat Pasien
                            </a>
                            <a href="#" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Laporan Sesi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 