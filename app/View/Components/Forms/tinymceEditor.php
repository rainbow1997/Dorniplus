<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
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
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.forms.tinymce-editor');
    }
}
