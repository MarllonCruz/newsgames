<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Models\User;

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

        return view('admin/post/index', [
            'user' => $user,
            'active' => 'post'
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
        // tamanho minimo COVER width:1420 height:800
        $data = $request->only([
            'title',
            'subtitle',
            'category',
            'cover',
            'body'
        ]);
        $data['slug'] = Str::slug($data['title'], '-');

        $validator = Validator::make($data, [
            'title' => 'required|string|max:100',
            'subtitle' => 'required|string|max:100',
            'category' => ['required', Rule::in(['news', 'reviews', 'artigo'])],
            'cover'    => 'image|mimes:jpg,png,jpeg|max:2000|dimensions:min_width=1420,min_height=800',
            'body'     => 'required|string'
        ]);
        if($validator->fails()) {
            return redirect()->route('post.create')
            ->withErrors($validator)
            ->withInput();
        }

        
        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
