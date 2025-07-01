<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\Backend\PostRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
    	$posts = Post::query()
            ->with(['category', 'user'])
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

        $insertedTags = $this->tagService->filterAndInsertTag($data['tags']);

        $post = $this->service->storeWithTags($data, $insertedTags);

        flash(__('backend.text.success'))->success();

        return redirect(route('backend.posts.index'));
    }

    public function edit(Post $post)
    {
        $tags = implode(',', $this->tagService->fetchAll(['name'])->pluck('name')->toArray());

        $categories = $this->categoryService
            ->fetchAll([
                'id',
                'name'
            ])
            ->pluck('name', 'id')
            ->toArray();

        $usedTags = $this->service->getUsedTags($post);

        $post->tags = $usedTags;

        return view('backend.posts.update', compact([
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

        $insertedTags = $this->tagService->filterAndInsertTag($data['tags']);
        unset($data['tags']);
        $this->service->updateWithTag($post, $insertedTags, $data);

        flash(__('backend.text.success'))->success();

        return redirect(route('backend.posts.index'));
    }

    public function destroy($id)
    {
        $this->service->delete([$id]);

        flash(__('backend.text.success'))->success();

        return redirect()->route('backend.posts.index');
    }
}
