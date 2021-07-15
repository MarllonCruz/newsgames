<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Slider;
use App\Models\Highlight;
use App\Models\Visitor;

class HomeController extends Controller
{
    public function index(Request $request) {
        $sliders     = [];
        $highlights  = [];
        $latestPosts = [];

        // Pegando posts do sliders
        $idsSliders = Slider::all();
        foreach($idsSliders as $idSlider) {
            if($idSlider->id_post) {
                $sliders[] = Post::select()->where('id', $idSlider->id_post)->first();
            }
        }
        foreach($sliders as $item) {
            $item->active = '';
        }
        $sliders[0]->active = 'active';

        // Pegando posts do Highlights
        $highlights = Highlight::all();
        foreach($highlights as $highlight) {
           $highlight->post = $highlight->post()->first();
           if(!$highlight->post) {
               $highlight->post = Post::select()->where('status', '1')
               ->orderBy('created_at', 'DESC')->first();
           }
           $highlight->post->date = date('H', strtotime($highlight->post->created_at)).' hours ';
           $highlight->post->date .= date('(d F)', strtotime($highlight->post->created_at));
           
        }

        // Pegando posts dos últimas 
        $latestPosts = Post::select()->where('category', 'news')
        ->where('status', '1')->paginate(5);
        foreach($latestPosts as $post) {
            $post->date = date('H', strtotime($post->created_at)).' hours ';
            $post->date .= date('(d F)', strtotime($post->created_at));
        }

        // Registrar a visualização pelo IP do usúario
        $ip = $request->ip();
        if($ip) {
            $v = new Visitor();
            $v->ip          = $ip;
            $v->date_access = date('Y-m-d H:i:s');
            $v->page        = '/';
            $v->save();
        }

        return view('site/home', [
            'sliders'     => $sliders,
            'highlights'  => $highlights,
            'latestPosts' => $latestPosts,
            'header'      => true
        ]);
    }

    public function filter(Request $request)
    {   
        $filterCategory = [];
        $posts          = [];

        $data = $request->only([
            's', 'news',
            'reviews', 'artigos'
        ]);
        if(isset($data['news'])) {
            $filterCategory[] = 'news';
        }
        if(isset($data['reviews'])) {
            $filterCategory[] = 'reviews';
        }
        if(isset($data['artigos'])) {
            $filterCategory[] = 'artigo';
        }

        if(empty($filterCategory)) {
            $posts = Post::select()->where('status', '1')
                ->where('title', 'like', '%' . $request->s . '%')
                ->orderBy('created_at', 'DESC')
            ->paginate(10);
        } else {
            $posts = Post::select()->where('status', '1')
                ->whereIn('category', $filterCategory)
                ->where('title', 'like', '%' . $request->s . '%')
                ->orderBy('created_at', 'DESC')
            ->paginate(10);
        }

        return view('site/filter', [
            'posts'  => $posts,
            'data'   => $data,
            'header' => false
        ]);
    }

    public function post(Request $request)
    {
        $feed = Post::select()->where('slug', $request->slug)
            ->where('status', '1')->first();
        if (!$feed) {
            return redirect('/');
        }

        $feed->date =date('H', strtotime($feed->created_at)).' hours ';
        $feed->date .= date('(d F)', strtotime($feed->created_at));

        $latestPosts = Post::select()->where('category', 'news')
        ->where('status', '1')->paginate(5);
        foreach($latestPosts as $post) {
            $post->date = date('H', strtotime($post->created_at)).' hours ';
            $post->date .= date('(d F)', strtotime($post->created_at));
        }

        $ip = $request->ip();
        if($ip) {
            $v = new Visitor();
            $v->ip          = $ip;
            $v->date_access = date('Y-m-d H:i:s');
            $v->page        = $feed->slug;
            $v->save();
        }

        return view('site/feed', [
            'feed'        => $feed,
            'header'      => false,
            'latestPosts' => $latestPosts
        ]);
    }
}
