<?php

namespace App\View\Components\botao;

use Illuminate\View\Component;

class BtnExcluir extends Component
{
    public $rota;
    public $titulo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($rota, $titulo)
    {
        $this->rota   = $rota;
        $this->titulo = $titulo;
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
