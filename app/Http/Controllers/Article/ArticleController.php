<?php

namespace Dipnet\Http\Controllers\Article;

use Dipnet\Article;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Article\StoreArticleRequest;
use Dipnet\Http\Requests\Article\UpdateArticleRequest;

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Article::class);

        return view('articles.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return Article|\Illuminate\Database\Eloquent\Model
     */
    public function store(StoreArticleRequest $request)
    {
        $article = new Article;
        $article->reference = $request->reference;
        $article->description = $request->description;
        $article->type = $request->type;
        $article->greyscale = $request->greyscale;
        $article->save();

        return response($article, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
        $article->reference = $request->reference;
        $article->description = $request->description;
        $article->type = $request->type;
        $article->greyscale = $request->greyscale;
        $article->save();

        return response($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return response(null, 204);
    }
}
