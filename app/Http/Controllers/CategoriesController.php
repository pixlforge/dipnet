<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Categories.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Category::class);

        $categories = Category::latest()
            ->orderBy('name')
            ->get()
            ->toJson();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the view responsible for the creation of a new Category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('categories.create');
    }

    /**
     * Persist a new Category model.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        $category = Category::create([
            'name' => request('name'),
        ]);

        // Process the Axios http request and return the model's id.
        if (request()->wantsJson()) {
            return $category->id;
        }

        return redirect()->route('categories');
    }

    /**
     * Display the specified Category.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view', $category);

        return view('categories.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update([
            'name' => request('name')
        ]);

        if (request()->expectsJson()) {
            return response([], 204);
        }

        return redirect()->route('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('categories');
    }
}
