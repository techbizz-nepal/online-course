<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showPasswordChangeForm(){
        return view('admin.change-password');
    }

    public function change(Request $request){
        $user = auth()->user();
        $request->validate([
           'password' => 'required | min: 8 | confirmed'
        ]);
        $password = Hash::make($request->get('password'));
        $user->update([
           'password' => $password
        ]);
        auth()->logout();
        return redirect()->route('admin.dashboard');
    }
}
