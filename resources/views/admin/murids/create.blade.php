@extends('layouts.admin')
@section('title','Tambah Murid')
@section('body')
<form action="{{ route('admin.murids.store') }}" method="POST">
    @csrf
        <div>
            <label>Nama</label>
            <input name="nama" required value="{{ old('nama') }}">
            <x-input-error :messages="$errors->get('nama')" />
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
            <label>Kelas</label>
            <select name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- Pilih Kelas (opsional) --</option>
                @for($i=1;$i<=6;$i++)
                    <option value="{{ $i }}" {{ (string)old('kelas_id') === (string)$i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
                @if(isset($kelas))
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ (string)old('kelas_id') === (string)$k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                @endif
            </select>
            <x-input-error :messages="$errors->get('kelas_id')" />
        </div>
        <div>
            <label>Alamat</label>
            <textarea name="alamat">{{ old('alamat') }}</textarea>
            <x-input-error :messages="$errors->get('alamat')" />
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
