<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user')->paginate(20);
        return view('admin.gurus.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.gurus.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'nip' => 'nullable|string',
            'password' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'] ?? 'password'),
            'email' => ($request->input('email') ?? ($data['username'].'@example.test')),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nip' => $data['nip'] ?? null,
            'nama' => $data['name'],
        ]);

    session()->flash('success', 'Guru berhasil dibuat.');
    return redirect()->route('admin.gurus.index');
    }

    public function edit(Guru $guru)
    {
        return view('admin.gurus.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'nip' => 'nullable|string',
        ]);

    $guru->update($data);
        if ($request->filled('password')) {
            $guru->user->update(['password' => Hash::make($request->password)]);
        }

    session()->flash('success', 'Perubahan guru disimpan.');
    return redirect()->route('admin.gurus.index');
    }

    public function destroy(Guru $guru)
    {
        // Prevent deleting if guru is wali for any kelas
        if (method_exists($guru, 'kelas') && $guru->kelas()->exists()) {
            session()->flash('error', 'Guru tidak dapat dihapus karena masih menjadi wali di satu atau lebih kelas. Lepaskan peran wali terlebih dahulu.');
            return back();
        }

        // Also delete linked user if exists
        try {
            if($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();
            session()->flash('success', 'Guru dan akun pengguna terkait telah dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
        return back();
    }

    // Download CSV template for guru import
    public function template()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="guru-template.csv"',
        ];
        $columns = ['nama','username','email','nip'];
        $callback = function() use($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }

    // Import uploaded CSV for gurus
    public function import(Request $request)
    {
        $request->validate([ 'file' => 'required|file' ]);
        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if(!$handle) { session()->flash('error','Gagal membuka file.'); return back(); }

        $header = fgetcsv($handle);
        if(!$header) { fclose($handle); session()->flash('error','File kosong atau format tidak dikenali.'); return back(); }

        $created = 0; $skipped = 0; $errors = [];
        while(($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            if(!$data) { $errors[] = 'Baris format salah'; $skipped++; continue; }

            $nama = trim($data['nama'] ?? '');
            $username = trim($data['username'] ?? '');
            $email = trim($data['email'] ?? '');
            $nip = trim($data['nip'] ?? null);

            if(!$nama || !$username) { $errors[] = "Missing nama/username for row username={$username}"; $skipped++; continue; }
            if( \App\Models\User::where('username',$username)->exists() ) { $errors[] = "Username {$username} sudah ada"; $skipped++; continue; }

            try {
                $password = Str::slug($nama) ?: 'password';
                $user = \App\Models\User::create([
                    'name' => $nama,
                    'username' => $username,
                    'email' => $email ?: ($username.'@example.test'),
                    'password' => Hash::make($password),
                    'role' => 'guru',
                ]);

                \App\Models\Guru::create([
                    'user_id' => $user->id,
                    'nip' => $nip ?: null,
                    'nama' => $nama,
                ]);

                $created++;
            } catch(\Exception $e) {
                $errors[] = "Gagal simpan row username={$username}: " . $e->getMessage();
                $skipped++;
            }
        }
        fclose($handle);

        $msg = "Import selesai. Berhasil: {$created}. Dilewati: {$skipped}.";
        if(count($errors)) session()->flash('error', $msg . ' Beberapa error: ' . implode('; ', array_slice($errors,0,5))); else session()->flash('success', $msg);
        return redirect()->route('admin.gurus.index');
    }
}
