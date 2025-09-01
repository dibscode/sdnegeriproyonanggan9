@extends('layouts.admin')
@section('title','Daftar Murid')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Murid
@endsection
@section('action')
<div class="flex items-center space-x-2">
	<a href="{{ route('admin.murids.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Murid</a>
	<a href="{{ route('admin.murids.template') }}" class="px-3 py-1 bg-green-600 text-white rounded">Download Template</a>
	<form action="{{ route('admin.murids.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
		@csrf
		<input type="file" name="file" accept=".csv,.xlsx,.xls" class="text-sm" />
		<button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Upload</button>
	</form>
</div>
@endsection
@section('body')
@if(session('success'))
	<div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
@endif
@if(session('error'))
	<div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
@endif
<!-- Debug: show collection count and IDs to help troubleshoot why only one row displays -->
@if(isset($murids))
	<div class="mb-2 text-sm text-gray-600">Debug: total koleksi murids = <strong>{{ $murids->count() }}</strong>.
	@if($murids->count()) IDs: @foreach($murids as $dm) <span class="mx-1">[id:{{ $dm->id }} uid:{{ $dm->user_id }}]</span> @endforeach @endif
	</div>
@endif
@if($murids->isEmpty())
	<div class="text-gray-600">Belum ada data murid. Klik "Tambah Murid" untuk menambah.</div>
@else
	<div class="overflow-x-auto">
	<table class="min-w-full divide-y divide-gray-200 mt-2">
		<thead class="bg-gray-50"><tr>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">ID</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">User ID</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Username</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Email</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Kelas</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Dibuat</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Diubah</th>
			<th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
		</tr></thead>
		<tbody class="bg-white divide-y divide-gray-100">
		@foreach($murids as $m)
			<tr>
				<td class="px-3 py-2 text-sm">{{ $m->id }}</td>
				<td class="px-3 py-2 text-sm">{{ $m->user_id ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">{{ $m->user->username ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">{{ $m->user->email ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">{{ $m->nama }}</td>
				<td class="px-3 py-2 text-sm">{{ $m->kelas->nama ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">{{ optional($m->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">{{ optional($m->updated_at)->format('Y-m-d H:i') ?? '-' }}</td>
				<td class="px-3 py-2 text-sm">
					<a class="inline-block px-2 py-1 bg-yellow-500 text-white rounded text-xs mr-2" href="{{ route('admin.murids.edit',$m) }}">Edit</a>
					<form id="delete-murid-{{ $m->id }}" action="{{ route('admin.murids.destroy',$m) }}" method="POST" style="display:inline">@csrf @method('DELETE')
						<button data-confirm-delete data-target-form="#delete-murid-{{ $m->id }}" class="inline-block px-2 py-1 bg-red-600 text-white rounded text-xs">Hapus</button>
					</form>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	<!-- Pagination removed: $murids->links() not available for Collection -->
@endif
@endsection
