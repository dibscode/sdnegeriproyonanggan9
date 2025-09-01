@extends('layouts.admin')
@section('title','Kelas Saya')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Nilai / Kelas
@endsection
@section('body')
@if(request()->query('debug'))
    <div class="p-3 mb-3 bg-yellow-50 border rounded text-sm text-gray-700">
        <div><strong>DEBUG:</strong></div>
        <div>Auth user id: {{ auth()->user()->id ?? '-' }}</div>
        <div>Auth user name: {{ auth()->user()->name ?? '-' }}</div>
        <div>Related Guru id: {{ optional(auth()->user()->guru)->id ?? '-' }}</div>
        <div class="mt-2">Semua kelas (id => nama => wali_guru_id):</div>
        <ul class="text-xs mt-1">
            @foreach(\App\Models\Kelas::all() as $kk)
                <li>{{ $kk->id }} => {{ $kk->nama }} => {{ $kk->wali_guru_id }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="text-lg font-medium mb-4">Daftar Kelas yang Anda Wali</h2>
@if(!empty($matchMethod))
    <div class="p-2 mb-3 text-sm bg-blue-50 border rounded text-blue-700">Catatan: data kelas dicocokkan menggunakan metode "{{ $matchMethod }}" (fallback).</div>
@endif
@if($kelas->isEmpty())
    <div class="text-gray-600">Anda belum ditugaskan sebagai wali di kelas manapun.</div>
@else
    <ul class="space-y-2">
    @foreach($kelas as $k)
        <li>
            <a class="block p-3 border rounded hover:bg-gray-50" href="{{ route('guru.nilais.murid.index',$k) }}">
                <div class="font-semibold">{{ $k->nama }}</div>
                <div class="text-sm text-gray-500">Wali: {{ $k->wali->nama ?? '-' }}</div>
            </a>
        </li>
    @endforeach
    </ul>
@endif
@endsection
