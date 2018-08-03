<?php

namespace App\Http\Controllers\Comment;

use App\Business;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreCommentRequest $request, Business $business)
    {
        $this->authorize('comment', $business);

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $business->comments()->save($comment);
        $comment->save();

        return response($comment, 200);
    }
}
