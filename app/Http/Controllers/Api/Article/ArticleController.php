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
        $this->middleware(['admin']);
    }

    /**
     * @return ArticlesCollection
     */
    public function index()
    {
        return new ArticlesCollection(
            Article::orderBy('type', 'greyscale')
                ->paginate(25)
        );
    }
}
