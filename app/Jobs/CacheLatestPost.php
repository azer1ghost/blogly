<?php

namespace App\Jobs;

use Exception;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;

class CacheLatestPost implements ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * @throws Exception
     */
    public function handle()
    {
        $posts = PostResource::collection(
            Post::published()
                ->with('user')
                ->latest('publication_date')
                ->take(200)
                ->get()
        );

        $cacheTime = app()->environment('local') ? now()->addMinute(): now()->addHour();

        cache([Post::cacheKey() => $posts], $cacheTime);
    }
}
