<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;

class RequestController extends Controller
{
    public function create()
    {
        if (! Gate::allows('create-request')){
            abort(401);
        }

        return view('request.create');
    }

    public function store(Request $request)
    {

        if (! Gate::allows('create-request')){
            abort(401);
        }

        $var = \App\Models\Request::create([
            'user_id' => Auth::user()->id,
            'nome' => request('nome'),
            'cognome' => request('cognome'),
            'data_nascita' => request('data_nascita'),
            'codice_documento' => request('codice_documento'),
            'tipo_documento' => request('tipo_documento')
        ]);

        return redirect('/');
    }

}
