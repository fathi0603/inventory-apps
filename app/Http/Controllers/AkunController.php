<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $user = UserLogin::find(session('id_user'));

        return view('akun.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:5',
            'konfirmasi'    => 'required|same:password_baru',
        ]);

        $user = UserLogin::find(session('id_user'));

        if (!$user) {
            return redirect('/login');
        }

        $passwordValid = false;

        // Password sudah menggunakan hash
        if (
            str_starts_with($user->password, '$2y$') ||
            str_starts_with($user->password, '$2a$') ||
            str_starts_with($user->password, '$2b$')
        ) {
            $passwordValid = Hash::check(
                $request->password_lama,
                $user->password
            );
        } else {
            // Kompatibilitas akun lama yang masih plaintext
            $passwordValid = ($user->password === $request->password_lama);
        }

        if (!$passwordValid) {
            return back()->with('error', 'Password lama salah');
        }

        // Password baru disimpan dalam bentuk hash
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
