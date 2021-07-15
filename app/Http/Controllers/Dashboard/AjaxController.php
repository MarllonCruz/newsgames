<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Post;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPostSearch(Request $request) {
        $data = [];

        if($request->category === 'all') {
            $data = Post::select()->where('title', 'like', '%' . $request->s . '%')
            ->orderBy('created_at', 'DESC')->get();
        } else {
            $data = Post::select()->where('title', 'like', '%' . $request->s . '%')
                ->where('category', $request->category)
                ->orderBy('created_at', 'DESC')
            ->get();
        }

        foreach($data as $item) {
            $item->created_at = date('d/m/Y', strtotime($item->created_at));
            $item->user = $item->autor()->first();
        }

        echo json_encode($data);
        return;
    }
}
