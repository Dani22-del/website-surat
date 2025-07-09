<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;


class LoginController extends Controller
{
       public function aksi_login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required'],
        'password' => ['required'],
    ], [
        'email.required' => 'Email tidak sesuai.',
        'password.required' => 'Password tidak sesuai.',
    ]);

     if (Auth::attempt($credentials)) {
    $user = Auth::user();
    if ($user->level_user == 'admin_devisi') {
        $redirect = url('/dashboard_admin');
    } elseif ($user->level_user == 'kepala_arsip') {
        $redirect = url('/dashboard_admin');
    } elseif ($user->level_user == 'direktur') {
        $redirect = url('/dashboard_admin');
    } else {
        return ['code' => '201', 'status' => 'error', 'message' => 'Error: Anda tidak memiliki akses'];
    }
    $request->session()->regenerate();
    return ['code' => '200', 'status' => 'success', 'message' => 'Berhasil Login', 'redirect' => $redirect];
    } else {
    return ['code' => '401', 'status' => 'error', 'message' => 'Error: Invalid credentials'];
    }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    // return back()->withErrors([
    //     'name' => 'The provided credentials do not match our records.',
    // ])->onlyInput('name');
}


    public function logout()  {
        Auth::logout();
        return redirect('/login');
    }

    public function login() {
     
    //   return $data['data'] = SortirGudang::where('kode_unik','AVO-0001-67a0ee8624006')->with(['setoran.kebunpetani', 'setoran.kebunpengepul'])->get();
  
        return view('login.login');
    }
}
