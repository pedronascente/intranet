<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuloController extends Controller
{

    public function index()
    {
        return view('modulo.index');
    }

    public function create()
    {
        return view('modulo.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        dd($id);
    }

    public function edit($id)
    {
        return view('modulo.edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        dd($id);
    }
}
