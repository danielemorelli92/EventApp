<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class RequestController extends Controller
{
    public function create()
    {
        if (Gate::denies('create-request')) {
            return redirect('/dashboard');
        }
        return view('request.create');
    }

    public function store()
    {
        if (Gate::denies('create-request')) {
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

    public function show_list()
    {
        if(Auth::user()->type != 'admin'){
            abort(401);
        }

        if (request('search') != null && ! blank(request('search'))){
            $requests = Request::query()
                ->where('id', '=', request('search'))
                ->orWhere('nome', 'like', '%' . request('search') . '%')
                ->orWhere('cognome', 'like', '%' . request('search') . '%')
                ->orWhere('data_nascita', 'like', '%' . request('search') . '%')
                ->orWhere('codice_documento', 'like', '%' . request('search') . '%')
                ->orWhere('tipo_documento', 'like', '%' . request('search') . '%');
        } else{
            $requests = Request::all();
        }


        $pending_requests = $requests->filter(function (Request $request){
           return $request->user->type == 'normale';
        });

        $closed_requests = $requests->filter(function (Request $request){
            return $request->user->type == 'organizzatore';
        });

        $users = User::all();

        return view('admin_page', [
            'pending_requests' => $pending_requests,
            'closed_requests' => $closed_requests,
            'users' => $users
        ]);

    }

}
