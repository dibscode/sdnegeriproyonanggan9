@extends('layouts.admin')
@section('title','Gallery')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Gallery
@endsection
@section('action')
<a href="{{ route('galleries.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Gambar</a>
@endsection
@section('body')
@if($galleries->isEmpty())
	<div class="text-gray-600">Belum ada gambar di gallery.</div>
@else
	<div class="grid grid-cols-4 gap-3">
	@foreach($galleries as $g)
		<div class="border rounded overflow-hidden bg-white">
			<img src="{{ asset('storage/'.$g->path) }}" class="w-full h-32 object-cover">
			<div class="p-2 text-sm">{{ $g->keterangan }}</div>
		</div>
	@endforeach
	</div>
@endif
@endsection
