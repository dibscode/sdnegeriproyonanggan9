<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Selamat datang, {{ auth()->user()->name ?? auth()->user()->username }}</h3>
                    <p class="text-sm text-gray-600">Peran Anda: <strong>{{ auth()->user()->role ?? 'user' }}</strong></p>
                    <div class="mt-4 grid grid-cols-3 gap-4">
                        <div class="p-3 bg-gray-50 rounded text-center">
                            <div class="text-2xl font-bold">{{ \App\Models\Guru::count() }}</div>
                            <div class="text-sm text-gray-600">Guru</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded text-center">
                            <div class="text-2xl font-bold">{{ \App\Models\Murid::count() }}</div>
                            <div class="text-sm text-gray-600">Murid</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded text-center">
                            <div class="text-2xl font-bold">{{ \App\Models\Kelas::count() }}</div>
                            <div class="text-sm text-gray-600">Kelas</div>
                        </div>
                    </div>
                    {{-- Quick actions moved to main navigation for admin users --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
