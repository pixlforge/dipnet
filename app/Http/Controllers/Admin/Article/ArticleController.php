<?php

namespace App\Http\Controllers\Admin\Article;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.articles.index');
    }

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

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->reference = $request->reference;
        $article->description = $request->description;
        $article->type = $request->type;
        $article->greyscale = $request->greyscale;
        $article->save();

        return response($article, 200);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response(null, 204);
    }
}
