<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::orderByDesc('created_at')->withCount('posts')->paginate(config('common.per_page'));

        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->only('name'));
        $request->session()->flash('success', __('messages.created', ['name' => 'category']));

        return redirect(route('backend.categories.index'));
    }

    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    public function update($id, CategoryRequest $request)
    {
        Category::whereId($id)->update($request->only('name'));
        $request->session()->flash('success', __('messages.updated', ['name' => 'category']));

        return redirect(route('backend.categories.index'));
    }

    public function destroy(Category $category, Request $request)
    {
        $category->delete();
        $request->session()->flash('success', __('messages.deleted', ['name' => 'category']));

        return redirect(route('backend.categories.index'));
    }
}
