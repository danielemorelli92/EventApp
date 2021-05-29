<?php

namespace App\Http\Controllers;

use App\Models\Request;

class RequestController extends Controller
{
    public function create()
    {
        return view('request');
    }

    public function save()
    {
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
