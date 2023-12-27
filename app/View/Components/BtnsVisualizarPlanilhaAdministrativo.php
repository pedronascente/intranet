<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BtnsVisualizarPlanilhaAdministrativo extends Component
{
    public $planilha;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($planilha)
    {
        $this->planilha = $planilha;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.btns-visualizar-planilha-administrativo');
    }
}
