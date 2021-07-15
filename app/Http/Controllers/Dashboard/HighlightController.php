<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use App\Models\Highlight;

class HighlightController extends Controller
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
        
        $highlights = Highlight::select()->get();

        return view('admin.highlight.index', [
            'user'    => $user,
            'active'  => 'highlights',
            'highlights' => $highlights
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
            'small1', 'small2', 'small3',
            'small4', 'medium', 'large'
        ]);
        $message = [];

        // Verificar se exister id($value) na tabela Post
        foreach($data as $key => $value) {
            if($value) {
                $post = Post::select()->where('id', $value)->first();
                if(!$post) {
                    $message[$key] = 'Campo '.$key.' não existe index da postagem';
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
            $highlight = Highlight::select()->where('position', $key)->first();
            $highlight->id_post = $value;
            $highlight->save();
        }

        return redirect()->back()->with('success', 'Dados atualizado com sucesso!');
    } 
}
