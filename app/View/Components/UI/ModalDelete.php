<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class ModalDelete extends Component
{
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
