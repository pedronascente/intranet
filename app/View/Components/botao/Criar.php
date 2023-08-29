<?php

namespace App\View\Components\botao;

use Illuminate\View\Component;

class Criar extends Component
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
        $this->getRota($rota);
        $this->permissoes = $permissoes;
    }

    public function getRota($modulo)
    {
        switch ($modulo) {
            case 'cargo':
                $this->rota = route('cargo.create');
                break;
            case 'colaborador':
                $this->rota = route('colaborador.create');
                break;
            case 'empresa':
                $this->rota = route('empresa.create');
                break;
            case 'modulo':
                $this->rota = route('modulo.create');
                break;
            case 'permissao':
                $this->rota = route('permissao.create');
                break;
            case 'perfil':
                $this->rota = route('perfil.create');
                break;
            case 'usuario':
                $this->rota = route('user.create');
                break;
            case 'cartao':
                $this->rota = route('cartao.create');
                break;
            case 'base':
                $this->rota = route('base.create');
                break;
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.botao.criar');
    }
}
