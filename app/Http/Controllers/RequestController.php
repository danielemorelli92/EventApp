<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;

class RequestController extends Controller
{
    public function create()
    {
        if (!Gate::allows('create-request')) {
            abort(401);
        }

        if (\App\Models\Request::query()->where('user_id', "=", Auth::id())->get()->first() != null)
            return redirect('/dashboard');
        else
            return view('request.create');
    }

    public function store()
    {
        if (Gate::denies('create-request') || \App\Models\Request::query()->where('user_id', "=", Auth::id())->get()->first() != null) {
            abort(401);
        }

        $validatedData = request()->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'data_nascita' => 'required|date',
            'codice_documento' => 'required|string',
            'tipo_documento' => 'required|string'
        ]);

        $validatedData['user_id'] = Auth::id();


        \App\Models\Request::create($validatedData);


        return redirect('/dashboard');
    }

}
