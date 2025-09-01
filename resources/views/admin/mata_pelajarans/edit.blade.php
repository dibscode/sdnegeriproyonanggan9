@extends('layouts.admin')
@section('title','Edit Mata Pelajaran')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('admin.mata_pelajarans.index') }}">Mata Pelajaran</a> / Edit
@endsection
@section('body')
<form action="{{ route('admin.mata_pelajarans.update',$mapel) }}" method="POST">@csrf @method('PUT')
    <div class="mb-3">
        <label class="block text-sm">Nama</label>
        <input name="nama" value="{{ $mapel->nama }}" class="w-full px-2 py-1 border rounded" required />
    </div>
    <button class="px-3 py-1 bg-blue-600 text-white rounded">Simpan</button>
</form>
@endsection
