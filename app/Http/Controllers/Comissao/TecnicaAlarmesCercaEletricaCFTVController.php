<?php

namespace App\Http\Controllers\comissao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TecnicaAlarmesCercaEletricaCFTVController extends Controller
{
    public function __construct()
    {
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit($id)
    {
        dd($id);
    }

    public function update(Request $request, $id)
    {
        dd($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        dd($request, $id);
    }
}
