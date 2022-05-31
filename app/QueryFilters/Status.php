<?php

namespace App\QueryFilters;

class Status
{
    public function handle($query, $next)
    {
        if (request()->filled('status') && request('status') !== 'all') {

            switch (request('status')) {
                case 'draft':
                    $query->drafted();
                    break;
                case 'published':
                    $query->published();
                    break;
                case 'unpublished':
                    $query->unPublished();
                    break;
            }
        }

        return $next($query);
    }
}
