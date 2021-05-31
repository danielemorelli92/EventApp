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

    public function store()
    {

        if (! Gate::allows('create-request')){
            abort(401);
        }

        $validated_data = request()->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'data_nascita' => 'required|data',
            'codice_documento' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:255'
        ]);

        $validated_data['author_id'] = Auth::id();

        $var = \App\Models\Request::create($validated_data);

        return redirect('/');
    }

}
