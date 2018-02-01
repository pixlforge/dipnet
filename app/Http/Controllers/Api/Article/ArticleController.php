<?php

namespace Dipnet\Http\Controllers\Api\Article;

use Dipnet\Article;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\ArticlesCollection;

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
