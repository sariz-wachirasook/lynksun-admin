<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;


class AdminAuthenticationController extends Controller
{
    public function index()
    {
        return view('pages.admin.login.index');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])) {
                $user = auth()->guard('admin')->user();
                return redirect()->route('admin.dashboard')->with('success', 'You are Logged in sucessfully.');
            } else {
                return back()->with('error', 'Whoops! invalid email and password.');
            }
        } catch (\Exception $e) {
            return $this->failedLogin();
        }
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'You are Logged out sucessfully.');
    }

    public function failedLogin()
    {
        return redirect(route('admin.login'))->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
