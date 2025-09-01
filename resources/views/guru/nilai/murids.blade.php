@extends('layouts.admin')
@section('title','Murid Kelas ' . $kelas->nama)
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Nilai / <a href="{{ route('guru.nilais.kelas') }}">Kelas</a> / {{ $kelas->nama }}
@endsection
@section('body')
<h2 class="text-lg font-medium mb-4">Murid di {{ $kelas->nama }}</h2>
@if($murids->isEmpty())
    <div class="text-gray-600">Belum ada murid di kelas ini.</div>
@else
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 mt-2">
        <thead class="bg-gray-50"><tr>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Username</th>
            <th class="px-3 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
        </tr></thead>
        <tbody class="bg-white divide-y divide-gray-100">
        @foreach($murids as $m)
            <tr>
                <td class="px-3 py-2 text-sm">{{ $m->nama }}</td>
                <td class="px-3 py-2 text-sm">{{ $m->user->username ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">
                    @php
                        $params = [];
                        if (!empty($semester)) $params['semester'] = $semester;
                        if (!empty($tahun)) $params['tahun_ajaran'] = $tahun;
                    @endphp
                    <a class="inline-block px-2 py-1 bg-blue-600 text-white rounded text-xs" href="{{ route('guru.nilais.murid.edit', array_merge(['murid' => $m->id], $params)) }}">Input / Edit Nilai</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endif
@endsection
