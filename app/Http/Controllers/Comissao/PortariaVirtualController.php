<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Comissao\PortariaVirtual as PV;

class PortariaVirtualController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Portaria Virtual";
        $this->comissao = new ComissaoController();
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
