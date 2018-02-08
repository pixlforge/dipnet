<?php

namespace Dipnet\Http\Controllers\Comment;

use Dipnet\Business;
use Dipnet\Comment;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Comment\StoreCommentRequest;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @param Business $business
     * @param StoreCommentRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Business $business, StoreCommentRequest $request)
    {
        if (auth()->user()->company_id !== $business->company_id) {
            abort(403);
        }

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $business->comments()->save($comment);
        $comment->save();

        return response($comment, 200);
    }
}
