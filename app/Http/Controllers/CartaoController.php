<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cartao;

class CartaoController extends Controller
{
    public function index()
    {
        $cartoes =  Cartao::with('user')->get();
        return view('cartao.index', ['cartoes' => $cartoes]);
    }

    public function create()
    {
        $users = User::all();
        return view('cartao.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'status' => 'required',
                'user_id' => 'required',
            ],
            [

                'status.required' => 'Campo obrigatório.',
                'user_id.required' => 'Campo obrigatório.',
            ]
        );

        $user = User::findOrFail($request->user_id);

        $user->cartao()->create([
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        //$cartao->
        return redirect()
            ->action('App\Http\Controllers\CartaoController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        return view('cartao.show');
    }

    public function edit($id)
    {
        return view('cartao.edit');
    }

    public function update(Request $request, $id)
    {
        return view('cartao.idex');
    }


    public function destroy($id)
    {
        //
    }
}
