<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Post;
use App\Models\Visitor;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $countPosts    = 0;
        $countVisitors = 0;
        $countUsers    = 0;
        $countOnlines  = 0;

        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if(!$user) {
            Auth::logout();
            return redirect('/dashboard');
        }

        // Contagem de Postagem
        $countPosts = Post::count();
        // Contagem de Usúarios
        $countUsers = User::count();
        // Contagem de Visitas
        $countVisitors = Visitor::count();
        // Contagem de usúarios Online
        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $datelimit)->groupBy('ip')->get();
        $countOnlines = count($onlineList);

        return view('admin/home', [
            'user'          => $user,
            'active'        => 'home',
            'countPosts'    => $countPosts,
            'countVisitors' => $countVisitors,
            'countUsers'    => $countUsers,
            'countOnlines'  => $countOnlines
        ]);
    }
}
