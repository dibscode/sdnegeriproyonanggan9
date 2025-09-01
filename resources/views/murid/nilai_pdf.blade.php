<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nilai {{ $murid->nama ?? 'Murid' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width:100%; border-collapse: collapse; }
        th,td { border:1px solid #ddd; padding:8px; }
        th { background:#f4f4f4; }
    </style>
</head>
<body>
    <div style="text-align:center;">
        <h1>Sekolah Dasar Negeri Proyonanggan 9</h1>
        <h2>Daftar Nilai - {{ $murid->nama ?? '' }}</h2>
        <p>Kelas: {{ $murid->kelas->nama ?? '' }}</p>
        @if(!empty($semester) && !empty($tahun))
            <p>Semester: {{ $semester }} &nbsp; | &nbsp; Tahun Ajaran: {{ $tahun }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr><th>Mata Pelajaran</th><th>Nilai</th></tr>
        </thead>
        <tbody>
        @forelse($nilais as $n)
            <tr>
                <td>{{ $n->mapel->nama ?? 'Mapel' }}</td>
                <td>{{ $n->nilai }}</td>
            </tr>
        @empty
            <tr><td colspan="2">Belum ada nilai.</td></tr>
        @endforelse
        </tbody>
    </table>

    @if(!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class))
        <p style="margin-top:20px;color:gray">Tip: untuk mengunduh PDF otomatis, install package <code>barryvdh/laravel-dompdf</code> dan gunakan cara berikut: <code>composer require barryvdh/laravel-dompdf</code></p>
    @endif
</body>
</html>
