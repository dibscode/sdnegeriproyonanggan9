@extends('layouts.admin')
@section('title','Edit Murid')
@section('body')
<form action="{{ route('admin.murids.update',$murid) }}" method="POST" class="space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">User ID</label>
        <input name="user_id" value="{{ $murid->user_id }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input name="username" value="{{ $murid->user->username ?? '' }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input name="email" value="{{ old('email', $murid->user->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input name="nama" value="{{ old('nama', $murid->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Tgl Lahir</label>
        <input name="tgl_lahir" type="date" value="{{ old('tgl_lahir', $murid->tgl_lahir) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Alamat</label>
        <textarea name="alamat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('alamat', $murid->alamat) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Kelas</label>
        <select name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Pilih Kelas (opsional) --</option>
            @for($i=1;$i<=6;$i++)
                <option value="{{ $i }}" {{ (string)old('kelas_id', $murid->kelas_id) === (string)$i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
            @if(isset($kelas))
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ (string)old('kelas_id', $murid->kelas_id) === (string)$k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            @endif
        </select>
        <x-input-error :messages="$errors->get('kelas_id')" />
    </div>
    <div class="text-sm text-gray-600">Dibuat: {{ optional($murid->created_at)->format('Y-m-d H:i') ?? '-' }} | Diubah: {{ optional($murid->updated_at)->format('Y-m-d H:i') ?? '-' }}</div>
    <div class="flex items-center space-x-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        <a href="{{ route('admin.murids.index') }}" class="text-sm text-gray-600">Batal</a>
    </div>
</form>
@endsection
