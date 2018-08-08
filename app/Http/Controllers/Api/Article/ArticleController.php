<?php

namespace App\Http\Controllers\Api\Article;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlesCollection;

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
     * Fetch articles.
     *
     * @param null $sort
     * @return ArticlesCollection
     */
    public function index($sort = null)
    {
        if ($sort) {
            if ($sort === 'created_at') {
                return new ArticlesCollection(
                    Article::orderBy($sort, 'desc')->paginate(25)
                );
            } else {
                return new ArticlesCollection(
                    Article::orderBy($sort)->paginate(25)
                );
            }
        } else {
            return new ArticlesCollection(
                Article::orderBy('type', 'greyscale')->paginate(25)
            );
        }
    }
}
