<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use App\Models\Slider;

class SliderController extends Controller
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
            return redirect()->back();
        }
        
        $sliders = Slider::select()->get();

        return view('admin.slider.index', [
            'user'    => $user,
            'active'  => 'slider',
            'sliders' => $sliders
        ]);
    }

    public function save(Request $request)
    {
        $loggedId = intval( Auth::id() );
        $user = User::find($loggedId);
        if(!$user) {
            return redirect()->back();
        }
        
        $data = $request->only([
            'slider1', 'slider2', 'slider3',
            'slider4', 'slider5', 'slider6'
        ]);
        $message = [];

        // Verificar se exister id($value) na tabela Post
        foreach($data as $key => $value) {
            if($value) {
                $post = Post::select()->where('id', $value)->first();
                if(!$post) {
                    $message[$key] = 'Campo '.$key.' não existe index da postagem';
                }
                if($post && $post->status == 0) {
                    $message[$key] = 'ID '.$key.' está desativado da postagem';
                }
            }
        }

        // Verificar se tem errors na $message 
        if(!empty($message)) {
            Session::flash('error', $message);
            return redirect()->back();
        }

        // Salvar as informações caso se foi aprovado todas etapas de cima
        foreach($data as $key => $value) {
            $slider = Slider::select()->where('slider_key', $key)->first();
            $slider->id_post = $value;
            $slider->save();
        }

        return redirect()->back()->with('success', 'Dados atualizado com sucesso!');
    }   
}
