@extends('layouts.admin')
@section('title','Tambah Guru')
@section('body')
<form action="{{ route('admin.gurus.store') }}" method="POST">
    @csrf
    <div>
        <label>Nama</label>
        <input name="name" required value="{{ old('name') }}">
        <x-input-error :messages="$errors->get('name')" />
    </div>
    <div>
        <label>Username</label>
        <input name="username" required value="{{ old('username') }}">
        <x-input-error :messages="$errors->get('username')" />
    </div>
    <div>
        <label>Email (opsional)</label>
        <input name="email" type="email" value="{{ old('email') }}">
        <x-input-error :messages="$errors->get('email')" />
    </div>
    <div>
        <label>NIP</label>
        <input name="nip" value="{{ old('nip') }}">
        <x-input-error :messages="$errors->get('nip')" />
    </div>
    <div>
        <label>Password</label>
        <input name="password" type="password">
        <div class="text-sm text-gray-500">Kosongkan untuk menggunakan password default.</div>
        <x-input-error :messages="$errors->get('password')" />
    </div>
    <x-primary-button>Simpan</x-primary-button>
</form>
@endsection
