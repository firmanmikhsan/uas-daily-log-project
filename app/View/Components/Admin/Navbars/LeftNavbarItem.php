<?php

namespace App\View\Components\Admin\Navbars;

use Illuminate\View\Component;

class LeftNavbarItem extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.navbars.left-navbar-item');
    }
}
