<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
    	$posts = Post::query()
            ->with(['category'])
            ->orderByDesc('created_at')
            ->paginate(config('common.per_page'));

        return view('backend.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        return view('backend.posts.create', compact([
            'categories',
        ]));
    }

    public function store(PostRequest $request)
    {
        $data = $request->only([
            'title',
            'category_id',
            'thumbnail',
            'tags',
            'excerpt',
            'content',
            'status',
        ]);
        // Upload thumbnail to storage and get the URL
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = asset('storage/' . $data['thumbnail']);
        } else {
            $data['thumbnail'] = null; // Set to null if no file is uploaded
        }

        // Create the post
        $post = Post::create([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'thumbnail' => $data['thumbnail'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'status' => $data['status'],
            'user_id' => auth()->id(),
        ]);

        // Attach tags if tags relationship exists
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect(route('backend.posts.index'))->with('success', __('backend.text.success'));
    }

    public function edit(Post $post)
    {
        // Get all tag names as a comma-separated string
        $tags = implode(',', Tag::query()->pluck('name')->toArray());

        // Get all categories as id => name array
        $categories = Category::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        // Get used tags for the post as a comma-separated string
        $usedTags = $post->tags()->pluck('name')->implode(',');

        // Set the tags attribute for the post (for form value)
        $post->tags = $usedTags;

        return view('backend.posts.edit', compact([
            'post',
            'categories',
            'tags',
        ]));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->only([
            'title',
            'category_id',
            'thumbnail',
            'tags',
            'excerpt',
            'content',
            'status',
        ]);

        // Upload thumbnail to storage and get the URL
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            $data['thumbnail'] = null; // Set to null if no file is uploaded
        }

        // Update post fields
        $post->update([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'thumbnail' => $data['thumbnail'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'status' => $data['status'],
        ]);

        // Handle tags
        $tagIds = [];
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
            foreach ($tags as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
        }
        $post->tags()->sync($tagIds);

        return redirect(route('backend.posts.index'))->with('success', __('backend.text.success'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        flash(__('backend.text.success'))->success();

        return redirect()->route('backend.posts.index');
    }
}
