<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartaoController extends Controller
{
    public function index()
    {
        return view('cartao.index');
    }

    public function create()
    {
        return view('cartao.create');
    }

    public function store(Request $request)
    {
        return view('cargo.index');
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
