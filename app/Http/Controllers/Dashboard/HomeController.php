<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);

        if(!$user) {
            Auth::logout();
            return redirect('/dashboard');
        }

        return view('admin/home', [
            'user' => $user
        ]);
    }
}
