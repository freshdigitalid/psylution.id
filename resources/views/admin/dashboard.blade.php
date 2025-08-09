<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat datang, {{ Auth::guard('admin')->user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Psikolog</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Psikolog::count() }}</p>
                        </div>
                        
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-green-800">Total Pasien</h4>
                            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Pasien::count() }}</p>
                        </div>
                        
                        <div class="bg-yellow-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Psikolog Pending</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Psikolog::where('is_verified', false)->count() }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold mb-4">Aksi Cepat</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Kelola Psikolog
                            </a>
                            <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Kelola Pasien
                            </a>
                            <a href="#" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 