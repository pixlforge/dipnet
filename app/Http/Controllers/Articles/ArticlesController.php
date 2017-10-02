<?php

namespace App\Http\Controllers\Articles;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Article::class);

        $articles = Article::with('category')
            ->orderBy('reference')
            ->get()
            ->toJson();

        return view('articles.index', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);

        $article = Article::create([
            'reference' => request('reference'),
            'description' => request('description'),
            'type' => request('type'),
            'category_id' => request('category')
        ]);

        if (request()->expectsJson()) {
            return $article->id;
        }

        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', $article);

        return view('articles.show', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update([
            'reference' => request('reference'),
            'description' => request('description'),
            'type' => request('type'),
            'category_id' => request('category')
        ]);

        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()->route('articles.index');
    }
}
