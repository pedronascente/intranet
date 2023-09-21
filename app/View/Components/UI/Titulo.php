<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Titulo extends Component
{
    public $segmentUm;
    public $segmentDois;
    public $titulo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($segmentUm, $segmentDois)
    {
        $this->segmentUm = $segmentUm;
        $this->segmentDois = $segmentDois;
        $this->definirSegmentacao();
    }

    public function definirSegmentacao()
    {
        if ($this->segmentUm  == 'settings') {
            if ($this->segmentDois !== null) {
                $this->titulo = $this->segmentDois;
            } else {
                $this->titulo = $this->segmentUm;
            }
        } else {
            $this->titulo = $this->segmentUm;
        }

        $this->getTitulo($this->titulo);
    }

    public function getTitulo($titulo)
    {

        switch ($titulo) {
            case 'dashboard':
                $this->titulo = "Dashboard";
                break;
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
                $this->titulo = "2FA";
                break;
            case 'base':
                $this->titulo = "Base";
                break;
            case 'profile':
                $this->titulo = "Meus dados";
                break;
            case 'settings':
                $this->titulo = "Configurações";
                break;
            case 'comissao':
                $this->titulo = "Comissão";
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
