<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogin;

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
}