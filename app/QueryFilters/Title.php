<?php

namespace App\QueryFilters;

class Title
{
    public function handle($query, $next)
    {
        if (request()->filled('title')) {
            $query->whereFullText(['title', 'description'], request('title'));
        }

        return $next($query);
    }
}
