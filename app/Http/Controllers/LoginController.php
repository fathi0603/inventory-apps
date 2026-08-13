<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function formLogin()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = UserLogin::where('username', $request->username)->first();

        if (!$user) {
            return redirect('/login')
                ->with('error', 'Username atau password salah');
        }

        $passwordValid = false;

        // Jika password di database sudah berupa hash bcrypt
        if (
            str_starts_with($user->password, '$2y$') ||
            str_starts_with($user->password, '$2a$') ||
            str_starts_with($user->password, '$2b$')
        ) {
            $passwordValid = Hash::check(
                $request->password,
                $user->password
            );
        } else {
            // Kompatibilitas dengan akun lama yang masih plaintext
            if ($user->password === $request->password) {
                $passwordValid = true;

                // Ubah password lama menjadi hash setelah login berhasil
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }

        if ($passwordValid) {
            session([
                'login'      => true,
                'id_user'    => $user->id_user,
                'id_petugas' => $user->id_petugas,
                'username'   => $user->username,
                'role'       => $user->role,
            ]);

            return redirect('/dashboard');
        }

        return redirect('/login')
            ->with('error', 'Username atau password salah');
    }

    public function akun()
    {
        $user = UserLogin::find(session('id_user'));

        return view('akun.index', compact('user'));
    }

    public function ubahPassword(Request $request)
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

        // Jika password lama sudah berupa hash
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
            // Kompatibilitas dengan password lama plaintext
            $passwordValid = ($user->password === $request->password_lama);
        }

        if (!$passwordValid) {
            return back()->with('error', 'Password lama salah');
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}
