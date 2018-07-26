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
