<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Highlight;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if(!$user) {
            Auth::logout();
            return redirect('/dashboard');
        }

        // Pegar todas postagens
        $posts = Post::select()->orderBy('created_at', 'DESC')->get();
        foreach($posts as $post) {
            $post->user = $post->autor()->first();
        }

        return view('admin/post/index', [
            'user'   => $user,
            'active' => 'post',
            'posts'  => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if(!$user) {
            Auth::logout();
            return redirect('/dashboard');
        }

        return view('admin/post/create', [
            'user' => $user,
            'active' => 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if(!$user) {
            Auth::logout();
            return redirect('/dashboard');
        }
        
        $data = $request->only([
            'title',
            'subtitle',
            'category',
            'cover',
            'body'
        ]);
        $data['slug'] = Str::slug($data['title'], '-');

        $validator = Validator::make($data, [
            'title'    => 'required|string|max:100',
            'subtitle' => 'required|string|max:150',
            'slug'     => 'required|string|max:200|unique:posts',
            'category' => ['required', Rule::in(['news', 'reviews', 'artigo'])],
            'cover'    => 'required|image|mimes:jpg,png,jpeg|max:2000|dimensions:min_width=1280,min_height=720',
            'body'     => 'required|string'
        ]);
        if($validator->fails()) {
            return redirect()->route('post.create')
            ->withErrors($validator)
            ->withInput();
        }

        $ext = $data['cover']->extension();
        $imageName = md5(time().rand(0,9999)).'.'.$ext;
        $data['cover']->move(public_path('media/covers'), $imageName);

        $post = new Post();
        $post->title        = $data['title'];
        $post->subtitle     = $data['subtitle'];
        $post->category     = $data['category'];
        $post->cover        = $imageName;
        $post->slug         = $data['slug'];
        $post->created_user = $user->id;
        $post->update_user  = $user->id;
        $post->created_at   = date('Y-m-d H:i:s');
        $post->body         = $data['body'];
        $post->save();

        return redirect()->route('post.index');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        $post = Post::find($id);
        if(!$post) {
            return redirect()->route('post.index');
        }

        return view('admin/post/edit', [
            'user' => $user,
            'active' => 'post',
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if(!$post) {
            return redirect()->route('post.edit', ['post'=>$id]);
        }

        $data = $request->only([
            'title',
            'subtitle',
            'category',
            'cover',
            'body'
        ]);
        $data['slug'] = Str::slug($data['title'], '-');
        $data['status'] = $request->status ? 1 : 0;
        $slug = 'required';
        if($data['slug'] != $post->slug) {
            $slug = 'required|string|max:200|unique:posts';
        } 

        $validator = Validator::make($data, [
            'title'    => 'required|string|max:100',
            'subtitle' => 'required|string|max:150',
            'category' => ['required', Rule::in(['news', 'reviews', 'artigo'])],
            'cover'    => 'image|mimes:jpg,png,jpeg|max:2000|dimensions:min_width=1279,min_height=719',
            'body'     => 'required|string',
            'slug'     => $slug
        ]);

        if($validator->fails()) {
            return redirect()->route('post.edit', ['post'=>$id])
            ->withErrors($validator)
            ->withInput();
        }

        $post->title        = $data['title'];
        $post->subtitle     = $data['subtitle'];
        $post->category     = $data['category'];
        $post->slug         = $data['slug'];
        $post->status       = $data['status'];
        $post->update_user  = $user->id;
        $post->body         = $data['body'];

        if(isset($data['cover']) && !empty($data['cover'])) {
            $img_url = public_path('media\covers\\'.$post->cover);
            if(file_exists($img_url)) {
                unlink($img_url);
            }
            $ext = $data['cover']->extension();
            $imageName = md5(time().rand(0,9999)).'.'.$ext;
            $data['cover']->move(public_path('media/covers'), $imageName);
            $post->cover = $imageName;
        }

        if($post->status == 0) {
            $slider = Slider::select()->where('id_post', $post->id)->first();
            if($slider) {
                $slider->id_post = null;
                $slider->save();
            }
            $highlight = Highlight::select()->where('id_post', $post->id)->first();
            if($highlight) {
                $highlight->id_post = null;
                $highlight->save();
            }
        }

        $post->save();
        return redirect()->back()->with('success', 'Dados atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(!$post) {
            return redirect()->route('post.index', ['post'=>$id]);
        }

        $img_url = public_path('media\covers\\'.$post->cover);
        if(file_exists($img_url)) {
            unlink($img_url);
        }
        $slider = Slider::select()->where('id_post', $post->id)->first();
        if($slider) {
            $slider->id_post = null;
            $slider->save();
        }
        $highlight = Highlight::select()->where('id_post', $post->id)->first();
        if($highlight) {
            $highlight->id_post = null;
            $highlight->save();
        }

        $post->delete();
        return redirect()->back();
    }
}
