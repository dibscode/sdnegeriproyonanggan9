@extends('layouts.admin')
@section('title','Edit Guru')
@section('body')
<form action="{{ route('admin.gurus.update',$guru) }}" method="POST" class="space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">User ID</label>
        <input name="user_id" value="{{ $guru->user_id }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('user_id')" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input name="username" value="{{ $guru->user->username ?? '' }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('username')" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input name="email" value="{{ old('email', $guru->user->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('email')" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input name="nama" value="{{ old('nama', $guru->nama) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('nama')" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">NIP</label>
        <input name="nip" value="{{ old('nip', $guru->nip) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('nip')" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Password <span class="text-sm font-normal text-gray-500">(kosongkan jika tidak diubah)</span></label>
        <input name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('password')" />
    </div>
    <div class="text-sm text-gray-600">Dibuat: {{ optional($guru->created_at)->format('Y-m-d H:i') ?? '-' }} | Diubah: {{ optional($guru->updated_at)->format('Y-m-d H:i') ?? '-' }}</div>
    <div class="flex items-center space-x-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        <a href="{{ route('admin.gurus.index') }}" class="text-sm text-gray-600">Batal</a>
    </div>
</form>
@endsection
