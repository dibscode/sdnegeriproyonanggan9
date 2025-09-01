@extends('layouts.admin')
@section('title','Tambah Kelas')
@section('body')
<form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-4">@csrf
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input name="nama" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        <x-input-error :messages="$errors->get('nama')" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Wali Guru</label>
        <select name="wali_guru_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Tidak ada --</option>
            @foreach(($gurus ?? []) as $g)
                <option value="{{ $g->id }}" {{ old('wali_guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }} @if($g->user) ({{ $g->user->username ?? $g->user->email }})@endif</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('wali_guru_id')" />
    </div>
    <div class="flex items-center space-x-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        <a href="{{ route('admin.kelas.index') }}" class="text-sm text-gray-600">Batal</a>
    </div>
</form>
@endsection
