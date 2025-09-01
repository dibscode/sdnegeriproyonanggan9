@extends('layouts.admin')
@section('title','Daftar Guru')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Guru
@endsection
@section('action')
<div class="flex items-center gap-2">
    <a href="{{ route('admin.gurus.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Guru</a>

    <a href="{{ route('admin.gurus.template') }}" class="px-3 py-1 bg-green-600 text-white rounded">Download Template</a>

    <form action="{{ route('admin.gurus.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
        @csrf
        <input type="file" name="file" accept=".csv" class="text-sm" />
        <button type="submit" class="px-3 py-1 bg-blue-600 text-black rounded">Import</button>
    </form>
</div>
@endsection
@section('body')
@if($gurus->isEmpty())
    <div class="text-gray-600">Belum ada data guru. Gunakan tombol di atas untuk menambah.</div>
@else
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 mt-2">
        <thead class="bg-gray-50"><tr>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">ID</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">User ID</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Username</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Email</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">NIP</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Dibuat</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Diubah</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
        </tr></thead>
        <tbody class="bg-white divide-y divide-gray-100">
        @foreach($gurus as $g)
            <tr>
                <td class="px-3 py-2 text-sm">{{ $g->id }}</td>
                <td class="px-3 py-2 text-sm">{{ $g->user_id ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ $g->user->username ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ $g->user->email ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ $g->nama }}</td>
                <td class="px-3 py-2 text-sm">{{ $g->nip }}</td>
                <td class="px-3 py-2 text-sm">{{ optional($g->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ optional($g->updated_at)->format('Y-m-d H:i') ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">
                    <a class="inline-block px-2 py-1 bg-yellow-500 text-white rounded text-xs mr-2" href="{{ route('admin.gurus.edit',$g) }}">Edit</a>
                    <form id="delete-guru-{{ $g->id }}" action="{{ route('admin.gurus.destroy',$g) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                        <button data-confirm-delete data-target-form="#delete-guru-{{ $g->id }}" class="inline-block px-2 py-1 bg-red-600 text-white rounded text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <div class="mt-4">{{ $gurus->links() }}</div>
@endif
@endsection
