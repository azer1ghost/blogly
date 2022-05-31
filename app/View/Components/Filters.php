<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Filters extends Component
{
    public array $filters;

    public function __construct($model)
    {
        $this->filters = $model::filters();
    }

    public function render()
    {
        return view('components.filters');
    }
}
