<?php

namespace App\Http\Controllers\Article;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of all the articles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Article::class);

        $articles = Article::with('category')
            ->latest()
            ->orderBy('reference')
            ->get()
            ->toJson();

        $categories = Category::orderBy('name')
            ->get()
            ->toJson();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return Article|\Illuminate\Database\Eloquent\Model
     */
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create([
            'reference' => $request->reference,
            'description' => $request->description,
            'type' => $request->type,
            'category_id' => $request->category_id
        ]);

        return $article;
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('view', Article::class);

        return view('articles.show', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update([
            'reference' => $request->reference,
            'description' => $request->description,
            'type' => $request->type,
            'category_id' => $request->category_id
        ]);

        return response($article, 200);
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

        return response(null, 204);
    }
}
