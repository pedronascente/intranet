<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class ModalDelete extends Component
{
    public $rota;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modulo)
    {
        $this->getRota($modulo);
    }

    public function getRota($modulo)
    {
        switch ($modulo) {
            case 'cargo':
                $this->rota = route('cargo.destroy', 1);
                break;
            case 'colaborador':
                $this->rota = route('colaborador.destroy', 1);
                break;
            case 'empresa':
                $this->rota = route('empresa.destroy', 1);
                break;
            case 'modulo':
                $this->rota = route('modulo.destroy', 1);
                break;
            case 'permissao':
                $this->rota = route('permissao.destroy', 1);
                break;
            case 'perfil':
                $this->rota = route('perfil.destroy', 1);
                break;
            case 'usuario':
                $this->rota = route('user.destroy', 1);
                break;
            case 'cartao':
                $this->rota = route('cartao.destroy', 1);
                break;
            case 'base':
                $this->rota = route('base.destroy', 1);
                break;
            case 'planilha':
                $this->rota = route('planilha.destroy', 1);
                break;
            case 'comissao':
                $this->rota = route('comissao.destroy', 1);
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
        return view('components.ui.modalDelete');
    }
}
