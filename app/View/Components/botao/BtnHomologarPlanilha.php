<?php

namespace App\View\Components\botao;

use Illuminate\View\Component;

class BtnHomologarPlanilha extends Component
{
    public $rota;
    

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($rota)
    {
        $this->rota = $rota;
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.botao.btn-homologar-planilha');
    }
}