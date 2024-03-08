<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $val = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($val->passes()) {
            if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password], $request->get('remember'))) {
                return redirect()->route('admin.dashboard');
            }
            else {
                return redirect()->route('admin.login')
                    ->with('error', 'Invalid Email or Password');
            }
        }
        else {
            return redirect()->route('admin.login')
                ->withErrors($val)
                ->withInput($request->only('email'));
        }
    }
}
