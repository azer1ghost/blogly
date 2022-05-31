<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\QueryFilters\{PublishDate, Status, Title};
use Illuminate\Http\{RedirectResponse, Request};
use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Post::class);
    }

    public function index(Request $request)
    {
        return view('panel.posts.index', [
                'posts' => $request->user()
                    ->posts()
                    ->filter([
                        Title::class,
                        PublishDate::class,
                        Status::class
                    ])
                    ->latest('id')
                    ->paginate($request->get('limit', 10))
                    ->withQueryString()
            ]);
    }

    public function create()
    {
        return view('panel.posts.edit')->with([
            'action' => route('posts.store'),
            'method' => 'POST',
            'data' => new Post([
                'publication_date' => now(),
            ]),
            'title' => 'Create'
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->file('image')) {

            $avatar = $request->file('image');

            $validated['image'] = $avatar->storeAs('posts', $avatar->hashName());
        }

        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index')->withNotify(['type' => 'success', 'message' => 'Yupi.. Created Success 🚀']);
    }

    public function show(Post $post)
    {
        return view('panel.posts.edit')->with([
            'action' => null,
            'method' => null,
            'data' => $post,
            'title' => 'View'
        ]);
    }

    public function edit(Post $post)
    {
        return view('panel.posts.edit')->with([
            'action' => route('posts.update', $post),
            'method' => 'PUT',
            'data' => $post,
            'title' => 'Edit'
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $oldImage = $post->getAttribute('image');

        $validated = $request->validated();

        if ($request->file('image')) {

            $image = $request->file('image');

            $validated['image'] = $image->storeAs('posts', $image->hashName());
        }

        $update = $post->update($validated);

        if ($update && $request->file('image') && $oldImage && Storage::exists($oldImage)) {
            Storage::delete($oldImage);
        }

        return redirect()->route('posts.index')->withNotify(['type' => 'success', 'message' => 'Yupi.. Saved success 😊']);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return back()->withNotify(['type' => 'success', 'message' => 'GG post ✋✋✋']);
    }
}
