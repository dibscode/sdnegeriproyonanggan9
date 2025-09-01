@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">@yield('title')</h1>
        <div>
            @hasSection('action')
                @yield('action')
            @endif
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @hasSection('breadcrumbs')
        <nav class="text-sm text-gray-600 mb-4">@yield('breadcrumbs')</nav>
    @endif

    <div class="bg-white shadow-sm rounded p-4">
        @yield('body')
    </div>
</div>
@endsection
