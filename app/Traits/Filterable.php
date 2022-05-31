<?php

namespace App\Traits;

use Illuminate\Pipeline\Pipeline;

trait Filterable
{
    public function scopeFilter($query, array $through)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($through)
            ->thenReturn();
    }
}
