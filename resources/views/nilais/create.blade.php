@extends('layouts.admin')
@section('title','Input Nilai')
@section('body')
<form action="{{ route('nilais.store') }}" method="POST">@csrf
    <div><label>Murid</label><select name="murid_id">@foreach($murids as $m)<option value="{{ $m->id }}">{{ $m->nama }}</option>@endforeach</select></div>
    <div><label>Mapel</label><select name="mata_pelajaran_id">@foreach($mapels as $mp)<option value="{{ $mp->id }}">{{ $mp->nama }}</option>@endforeach</select></div>
    <div><label>Nilai</label><input name="nilai"></div>
    <button type="submit">Simpan</button>
</form>
@endsection
