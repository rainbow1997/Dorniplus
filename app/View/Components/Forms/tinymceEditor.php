<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class tinymceEditor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $nameAttr;
    public function __construct($nameAttr)
    {
        //
        $this->nameAttr = $nameAttr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.tinymce-editor');
    }
}
