@extends('layouts.admin')
@section('title','Tambah Gambar')
@section('body')
<form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">@csrf
    <div><label>Gambar</label><input type="file" name="path"></div>
    <div><label>Keterangan</label><input name="keterangan"></div>
    <button type="submit">Simpan</button>
</form>
@endsection
