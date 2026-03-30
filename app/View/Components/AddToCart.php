<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddToCart extends Component
{
    public $product, $hasvariation, $hasaddon, $keywords, $activeTheme;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product = null, $hasvariation = false, $hasaddon = false, $keywords = [], $activeTheme = null)
    {
        $this->product = $product;
        $this->hasvariation = $hasvariation;
        $this->hasaddon = $hasaddon;
        $this->keywords = $keywords;
        $this->activeTheme = $activeTheme;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-to-cart');
    }
}
