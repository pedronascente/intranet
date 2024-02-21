<?php

namespace App\View\Components\botao;

use Illuminate\View\Component;

class BtnExcluir extends Component
{
    public $rota;
    public $arrayListPermissoesDoModuloDaRota;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($rota, $arrayListPermissoesDoModuloDaRota)
    {
        $this->rota = $rota;
        $this->arrayListPermissoesDoModuloDaRota = $arrayListPermissoesDoModuloDaRota;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.botao.btn-excluir');
    }
}
