<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MuridController extends Controller
{
    public function index()
    {
    $murids = Murid::with('user','kelas')->orderBy('id','desc')->get();
    // Users with role murid but missing murid record
    $missingCount = User::where('role','murid')->whereDoesntHave('murid')->count();
    $missingUsers = User::where('role','murid')->whereDoesntHave('murid')->limit(10)->get();
    return view('admin.murids.index', compact('murids','missingCount','missingUsers'));
    }

    public function create()
    {
            $kelas = Kelas::orderBy('nama')->get();
    return view('admin.murids.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $password = $request->input('password') ?? ($data['tgl_lahir'] ?? 'password');

        $user = User::create([
            'name' => $data['nama'],
            'username' => $data['username'],
            'password' => Hash::make($password),
            'email' => ($request->input('email') ?? ($data['username'].'@example.test')),
            'role' => 'murid',
        ]);

        Murid::create([
            'user_id' => $user->id,
            'nama' => $data['nama'],
            'tgl_lahir' => $data['tgl_lahir'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'kelas_id' => $data['kelas_id'] ?? null,
        ]);

    session()->flash('success', 'Murid berhasil dibuat.');
    return redirect()->route('admin.murids.index');
    }

    public function edit(Murid $murid)
    {
            $kelas = Kelas::orderBy('nama')->get();
        return view('admin.murids.edit', compact('murid','kelas'));
    }

    public function update(Request $request, Murid $murid)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

    $murid->update($data);

    session()->flash('success', 'Perubahan murid disimpan.');
    return redirect()->route('admin.murids.index');
    }

    public function destroy(Murid $murid)
    {
    $murid->delete();
    session()->flash('success', 'Murid dihapus.');
    return back();
    }

    // Download CSV template for import
    public function template()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="murid-template.csv"',
        ];
        $columns = ['nama','username','email','tgl_lahir','alamat','kelas_nama_or_id'];
        $callback = function() use($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }

    // Import uploaded CSV (basic parser). For production use maatwebsite/excel package.
    public function import(Request $request)
    {
        $request->validate([ 'file' => 'required|file' ]);
        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if(!$handle) {
            session()->flash('error','Gagal membuka file.');
            return back();
        }

        $header = fgetcsv($handle);
        if(!$header) { fclose($handle); session()->flash('error','File kosong atau format tidak dikenali.'); return back(); }

        $created = 0; $skipped = 0; $errors = [];
        while(($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            if(!$data) { $errors[] = 'Baris format salah'; $skipped++; continue; }

            // Map columns
            $nama = trim($data['nama'] ?? '');
            $username = trim($data['username'] ?? '');
            $email = trim($data['email'] ?? '');
            $tgl_lahir_raw = trim($data['tgl_lahir'] ?? null);
            $tgl_lahir = null;
            if($tgl_lahir_raw) {
                // Try common formats
                $formats = ['Y-m-d','m/d/Y','d/m/Y','m-d-Y','d-m-Y','Y/m/d'];
                foreach($formats as $fmt) {
                    try {
                        $d = Carbon::createFromFormat($fmt, $tgl_lahir_raw);
                    } catch (\Exception $e) {
                        // ignore and try next format
                        $d = null;
                    }
                    if($d && $d->format($fmt) === $tgl_lahir_raw) {
                        $tgl_lahir = $d->format('Y-m-d');
                        break;
                    }
                }
                // last resort try Carbon parse
                if(!$tgl_lahir) {
                    try { $d = Carbon::parse($tgl_lahir_raw); $tgl_lahir = $d->format('Y-m-d'); } catch(\Exception $e) { $tgl_lahir = null; }
                }
            }
            $alamat = trim($data['alamat'] ?? null);
            $kelas_ref = trim($data['kelas_nama_or_id'] ?? null);

            if(!$nama || !$username) { $errors[] = "Missing nama/username for row with username={$username}"; $skipped++; continue; }

            // Skip if username exists
            if( User::where('username',$username)->exists() ) { $errors[] = "Username {$username} sudah ada"; $skipped++; continue; }

            // Determine kelas_id: try numeric id first, else try find by nama
            $kelas_id = null;
            if($kelas_ref) {
                if(is_numeric($kelas_ref) && \App\Models\Kelas::where('id',$kelas_ref)->exists()) {
                    $kelas_id = (int)$kelas_ref;
                } else {
                    $k = \App\Models\Kelas::where('nama', $kelas_ref)->first();
                    if($k) $kelas_id = $k->id;
                }
            }

            // Create user and murid
            try {
                $password = Str::slug($nama) ?: 'password';
                $user = User::create([
                    'name' => $nama,
                    'username' => $username,
                    'email' => $email ?: ($username.'@example.test'),
                    'password' => Hash::make($password),
                    'role' => 'murid',
                ]);

                Murid::create([
                    'user_id' => $user->id,
                    'nama' => $nama,
                    'tgl_lahir' => $tgl_lahir ?: null,
                    'alamat' => $alamat ?: null,
                    'kelas_id' => $kelas_id,
                ]);

                $created++;
            } catch(\Exception $e) {
                $errors[] = "Gagal simpan row username={$username}: " . $e->getMessage();
                $skipped++;
            }
        }
        fclose($handle);

        $msg = "Import selesai. Berhasil: {$created}. Dilewati: {$skipped}.";
        if(count($errors)) {
            session()->flash('error', $msg . ' Beberapa error: ' . implode('; ', array_slice($errors,0,5)));
        } else {
            session()->flash('success', $msg);
        }

        return redirect()->route('admin.murids.index');
    }

    // Create murid rows for users with role 'murid' that don't have murid entries
    public function backfill(Request $request)
    {
        $users = User::where('role','murid')->whereDoesntHave('murid')->get();
        $created = 0;
        foreach($users as $u) {
            try {
                Murid::create([
                    'user_id' => $u->id,
                    'nama' => $u->name ?? $u->username,
                    'tgl_lahir' => null,
                    'alamat' => null,
                    'kelas_id' => null,
                ]);
                $created++;
            } catch(\Exception $e) {
                // ignore individual errors
            }
        }
        session()->flash('success', "Backfill selesai. Dibuat: {$created} murid baru.");
        return redirect()->route('admin.murids.index');
    }

    // Return JSON list of murids for debugging
    public function json()
    {
        return response()->json(Murid::with('user','kelas')->get());
    }
}
