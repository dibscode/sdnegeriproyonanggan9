@extends('layouts.admin')
@section('title','Daftar Kelas')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Kelas
@endsection
@section('action')
<a href="{{ route('admin.kelas.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Kelas</a>
@endsection
@section('body')
@if($kelas->isEmpty())
	<div class="text-gray-600">Belum ada kelas. Tambah kelas baru menggunakan tombol di atas.</div>
@else
	<div class="overflow-x-auto">
	<table class="min-w-full divide-y divide-gray-200 mt-2">
		<thead class="bg-gray-50"><tr>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">ID</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
				<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Wali</th>
				<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
		</tr></thead>
		<tbody class="bg-white divide-y divide-gray-100">
		@foreach($kelas as $k)
			<tr>
				<td class="px-3 py-2 text-sm">{{ $k->id }}</td>
				<td class="px-3 py-2 text-sm">{{ $k->nama }}</td>
				<td class="px-3 py-2 text-sm">{{ $k->wali->nama ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">
					<a href="{{ route('admin.kelas.edit', $k) }}" class="inline-block px-2 py-1 bg-yellow-500 text-white rounded text-xs mr-2">Edit</a>
					<form id="delete-kelas-{{ $k->id }}" action="{{ route('admin.kelas.destroy',$k) }}" method="POST" style="display:inline">@csrf @method('DELETE')
						<button data-confirm-delete data-target-form="#delete-kelas-{{ $k->id }}" class="inline-block px-2 py-1 bg-red-600 text-white rounded text-xs">Hapus</button>
					</form>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	<div class="mt-4">{{ $kelas->links() }}</div>
@endif
@endsection
