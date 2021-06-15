<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except'=>[
            'login',
            'loginAction'
        ]]);
    }

    public function login(Request $request)
    {
        return view('admin/auth/signin', [
            'error' => $request->session()->get('error')
        ]);
    }

    public function loginAction(Request $request)
    {
        $valitador = $this->validator($request->only(['email', 'password']));

        if($valitador->fails()) {
            return redirect()->route('login')
            ->withErrors($valitador)
            ->withInput();
        } 

        $user = Auth::attempt($request->only(['email', 'password']));
        if(!$user) {
            $valitador->errors()->add('incorrectData', 'E-mail e/ou senha incorretas');
            return redirect()->route('login')
            ->withErrors($valitador)
            ->withInput();
        }

        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/dashboard');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => 'required|string|email|max:100',
            'password' => 'required|string|min:3'
        ]);
    }
}
