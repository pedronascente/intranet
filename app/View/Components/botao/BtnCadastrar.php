<?php

namespace App\View\Components\botao;

use Illuminate\View\Component;

class BtnCadastrar extends Component
{
    public $rota;
    public $permissoes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($rota, $permissoes)
    {
        $this->rota       = $rota;
        $this->permissoes = $permissoes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.botao.btn-cadastrar');
    }
}
