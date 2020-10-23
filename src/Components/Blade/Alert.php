<?php

namespace Shopper\Framework\Components\Blade;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('shopper::components.alert');
    }
}
