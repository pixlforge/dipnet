<?php

namespace App\Http\Controllers\Admin\Article;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Hashids\HashidsGenerator;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.articles.index');
    }

    /**
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
