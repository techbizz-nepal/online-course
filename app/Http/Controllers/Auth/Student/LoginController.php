<?php

namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/student';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:student')->except('logout');
    }

    protected function redirectTo(Request $request): string
    {
        return route('student.getLoginForm');
    }
    public function showLoginForm(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.student.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('student')->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended($this->redirectTo);
        }

        return back()->withInput($request->only('email', 'remember'));
    }

}
