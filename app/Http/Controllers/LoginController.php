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
        $user = UserLogin::where('username', $request->username)
            ->where('password', $request->password)
            ->first();

        if ($user) {

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
            'password_baru' => 'required|min:6',
            'konfirmasi'    => 'required|same:password_baru',
        ]);

        $user = UserLogin::find(session('id_user'));

        if ($user->password != $request->password_lama) {
            return back()->with('error', 'Password lama salah');
        }

        $user->password = $request->password_baru;
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}