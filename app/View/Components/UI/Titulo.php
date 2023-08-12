<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Titulo extends Component
{
    public $titulo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($titulo)
    {
        $this->getTitulo($titulo);
    }

    public function getTitulo($titulo)
    {
        switch ($titulo) {
            case 'cargo':
                $this->titulo = "Cargo";
                break;
            case 'colaborador':
                $this->titulo = "Colaborador";
                break;
            case 'empresa':
                $this->titulo = "Empresa";
                break;
            case 'modulo':
                $this->titulo = "Módulo";
                break;
            case 'permissao':
                $this->titulo = "Permissão";
                break;
            case 'perfil':
                $this->titulo = "Perfil";
                break;
            case 'user':
                $this->titulo = "Usuário";
                break;
            case 'cartao':
                $this->titulo = "Cartão";
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
        return view('components.ui.titulo');
    }
}
