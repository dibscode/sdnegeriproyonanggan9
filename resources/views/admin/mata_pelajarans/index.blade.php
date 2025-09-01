@extends('layouts.admin')
@section('title','Mata Pelajaran')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Mata Pelajaran
@endsection
@section('action')
<a href="{{ route('admin.mata_pelajarans.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Tambah Mata Pelajaran</a>
@endsection
@section('body')
@if(session('success'))<div class="p-2 bg-green-100 text-green-800 mb-3">{{ session('success') }}</div>@endif
@if($mapels->isEmpty())
    <div class="text-gray-600">Belum ada mata pelajaran.</div>
@else
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 mt-2">
        <thead class="bg-gray-50"><tr>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
        </tr></thead>
        <tbody class="bg-white divide-y divide-gray-100">
        @foreach($mapels as $m)
            <tr>
                <td class="px-3 py-2 text-sm">
                    <a class="inline-block px-2 py-1 bg-yellow-500 text-white rounded text-xs mr-2" href="{{ route('admin.mata_pelajarans.edit',$m) }}">Edit</a>
                    <form action="{{ route('admin.mata_pelajarans.destroy',$m) }}" method="POST" style="display:inline">@csrf @method('DELETE')
                        <button data-confirm-delete data-target-form="#" class="inline-block px-2 py-1 bg-red-600 text-white rounded text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <div class="mt-4">{{ $mapels->links() }}</div>
@endif
@endsection
