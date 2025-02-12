<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers; // Laravel xử lý login/logout

    public function __construct()
    {
        // $this->middleware('guest')->except('logout'); // Chặn user đã đăng nhập vào trang login
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Trả về view đăng nhập
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }
    
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }
}
