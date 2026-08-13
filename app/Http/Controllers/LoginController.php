<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogin;

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

    // Cek password yang sudah di-hash
    $passwordValid = \Illuminate\Support\Facades\Hash::check(
        $request->password,
        $user->password
    );

    // Kompatibilitas dengan akun lama yang masih plaintext
    if (!$passwordValid && $user->password === $request->password) {
        $passwordValid = true;

        // Setelah berhasil login, ubah password lama menjadi hash
        $user->password = \Illuminate\Support\Facades\Hash::make(
            $request->password
        );

        $user->save();
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

    $passwordValid = \Illuminate\Support\Facades\Hash::check(
        $request->password_lama,
        $user->password
    );

    // Untuk akun lama yang masih plaintext
    if (!$passwordValid && $user->password === $request->password_lama) {
        $passwordValid = true;
    }

    if (!$passwordValid) {
        return back()->with('error', 'Password lama salah');
    }

    $user->password = \Illuminate\Support\Facades\Hash::make(
        $request->password_baru
    );

    $user->save();

    return back()->with('success', 'Password berhasil diubah');
}

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}