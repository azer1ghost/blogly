<?php

namespace App\QueryFilters;

class PublishDate
{
    public function handle($query, $next)
    {
        if (request()->filled('publication_date')) {
            $query->whereDate('publication_date', request('publication_date'));
        }

        return $next($query);
    }
}
