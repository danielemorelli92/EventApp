<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function create()
    {
        if (! Gate::allows('create-request')){
            abort(401);
        }

        return view('request');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nome' => 'required',
            'cognome' => 'required',
            'data_nascita' => 'required',
            'codice_documento' => 'required',
            'tipo_documento' => 'required'
        ]);

        if (! Gate::allows('create-request')){
            abort(401);
        }

        Request::create([
            'user_id' => Auth::user()->id,
            'nome' => request('nome'),
            'cognome' => request('cognome'),
            'data_nascita' => request('data_nascita'),
            'codice_documento' => request('codice_documento'),
            'tipo_documento' => request('tipo_documento')
        ]);
    }

}
