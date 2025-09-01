@extends('layouts.admin')
@section('title','Daftar Nilai')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Nilai
@endsection
@section('action')
<a href="{{ route('nilais.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Input Nilai</a>
@endsection
@section('body')
@if($nilais->isEmpty())
	<div class="text-gray-600">Belum ada data nilai. Masukkan nilai melalui tombol di atas.</div>
@else
	<div class="overflow-x-auto">
	<table class="min-w-full divide-y divide-gray-200 mt-2">
		<thead class="bg-gray-50"><tr>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Murid</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Mapel</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Nilai</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Semester/Tahun</th>
		</tr></thead>
		<tbody class="bg-white divide-y divide-gray-100">
		@foreach($nilais as $n)
			<tr>
				<td class="px-3 py-2 text-sm">{{ $n->murid->nama ?? $n->murid_id }}</td>
				<td class="px-3 py-2 text-sm">{{ $n->mapel->nama ?? $n->mata_pelajaran_id }}</td>
				<td class="px-3 py-2 text-sm">{{ $n->nilai }}</td>
				<td class="px-3 py-2 text-sm">{{ $n->semester }} / {{ $n->tahun_ajaran }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
@endif
@endsection
