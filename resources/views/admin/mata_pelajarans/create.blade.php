@extends('layouts.admin')
@section('title','Tambah Mata Pelajaran')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('admin.mata_pelajarans.index') }}">Mata Pelajaran</a> / Tambah
@endsection
@section('body')
<form action="{{ route('admin.mata_pelajarans.store') }}" method="POST">@csrf
    <div class="mb-3">
        <label class="block text-sm">Nama</label>
        <input name="nama" class="w-full px-2 py-1 border rounded" required />
    </div>
    <button class="px-3 py-1 bg-blue-600 text-white rounded">Simpan</button>
</form>
@endsection
