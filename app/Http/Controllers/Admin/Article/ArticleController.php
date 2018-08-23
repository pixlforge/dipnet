<?php

namespace App\Http\Controllers\Admin\Article;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Hashids\HashidsGenerator;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a list of all articles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.articles.index');
    }

    /**
     * Show an article.
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Store a new article.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $article = new Article;
        $article->description = $request->description;
        $article->type = $request->type;
        $article->greyscale = $request->greyscale;
        $article->save();

        $article->reference = HashidsGenerator::generateFor($article->id, 'articles');
        $article->save();

        return response($article, 200);
    }

    /**
     * Update an existing article.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->description = $request->description;
        $article->type = $request->type;
        $article->greyscale = $request->greyscale;
        $article->save();

        return response($article, 200);
    }

    /**
     * Delete an existing article.
     *
     * @param Article $article
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response(null, 204);
    }
}
