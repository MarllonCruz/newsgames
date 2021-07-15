<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;



use App\Models\User;

class UserController extends Controller
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
        if($user->master == 0) {
            return redirect()->back();
        }

        $colors = [
            '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
            '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
            '#f1c40f', '#e67e22', '#95a5a6', '#f39c12', '#f39c12',
            '#d35400', '#c0392b', '#7f8c8d'
        ];

        $users = User::select()->get();

        return view('admin/users/index', [
            'user'   => $user,
            'active' => 'user',
            'colors' => $colors,
            'users'  => $users
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
        if($user->master == 0) {
            return redirect()->back();
        }

        return view('admin/users/create', [
            'user'   => $user,
            'active' => 'user'
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
        if($user->master == 0) {
            return redirect()->back();
        }

        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $valitador = Validator::make($data, [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:3|confirmed'
        ]);
        
        if($valitador->fails()) {
            return redirect()->back()
            ->withErrors($valitador)
            ->withInput();
        }

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('user.index');
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
        if($user->master == 0) {
            return redirect()->back();
        }
        $data = User::find($id);
        if(!$data) {
            return redirect()->back();
        }

        return view('admin/users/edit', [
            'user'   => $user,
            'active' => 'user',
            'data'   => $data
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
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if($user->master == 0) {
            return redirect()->back();
        }
        $userAfter = User::find($id);
        if(!$userAfter) {
            return redirect()->back();
        }

        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);
        $validator = Validator::make($data, [
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:100'
        ]);

        if($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        // [ Alteração ]
        $userAfter->name = $data['name'];

        // Verificar se email novo é diferente do antigo
        if($userAfter->email != $data['email']) {
            // verificar se emial novo existo no banco
            $hasEmail = User::where('email', $data['email'])->get();
            if(count($hasEmail) > 0) {
                $validator->errors()->add('email', __('validation.confirmed', [
                    'attribute' => 'email'
                ]));
            }
            $userAfter->email = strtolower($data['email']);
        }

        // Verificar se adicionou senha nova 
        if(!empty($data['password'])) {
            if(strlen($data['password']) >= 3) {
                // verificar se duas senhas são iguais
                if($data['password'] !== $data['password_confirmation']) {
                    $validator->errors()->add('password', __('validation.confirmed', [
                        'attribute' => 'password'
                    ]));
                }
            } else {
                $validator->errors()->add('password', __('validation.min.string', [
                    'attribute' => 'password',
                    'min'       => 4
                ]));
            }
            $userAfter->password = Hash::make($data['password']);
        }

        if(count($validator->errors()) > 0) {
            return redirect()->route('user.edit', [
                'user' => $id
            ])->withErrors($validator);
        }

        $userAfter->save();
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
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if($user->master == 0) {
            return redirect()->back();
        }

        $data = User::where('id', $id)->first();
        if($data && $data->master != 1) {
            $data->delete(); 
        }
        return redirect()->route('user.index');
    }
}
