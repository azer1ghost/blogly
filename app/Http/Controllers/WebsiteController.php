<?php

namespace App\Http\Controllers;

use App\Jobs\CacheLatestPost;
use App\Models\Post;
use Exception;
use Psr\SimpleCache\InvalidArgumentException;

class WebsiteController extends Controller
{
    public function articles()
    {
        return view('website.articles');
    }

    /**
     * @throws Exception|InvalidArgumentException
     */
    public function getArticles()
    {
        if (!cache()->has(Post::cacheKey())){
            // if the schedule worker has not yet run the caching operation we must do caching for first time
            $this->dispatchSync(new CacheLatestPost());
        }

        $cachedLatestPost = cache(Post::cacheKey());

        $page = request('page', 1);
        $perPage = 10;

        $result = $cachedLatestPost->forPage($page, $perPage)->values()->toArray();

        return response()->json([
            'current' => $page,
            'posts' => $result,
        ]);
    }

    public function article(Post $post)
    {
        return view('website.article', compact('post'));
    }
}
