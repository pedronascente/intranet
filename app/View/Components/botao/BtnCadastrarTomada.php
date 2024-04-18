<?php

namespace App\View\Components\botao;

use Illuminate\View\Component;

class BtnCadastrarTomada extends Component
{
    


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.botao.btn-cadastrar-tomada');
    }
}
