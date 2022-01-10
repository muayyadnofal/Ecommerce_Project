<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentsRequest;
use App\src\Customer\Comment\AddComment;
use App\src\Customer\Comment\UpdateComment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(CommentsRequest $request, $id): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Comment\AddComment)->addComment($id, $request);
    }

    public function update(CommentsRequest $request, $product_id, $comment_id): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Comment\UpdateComment)->editComment($request, $product_id, $comment_id);
    }

    public function delete($product_id, $comment_id): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Comment\DeleteComment)->deleteComment($product_id, $comment_id);
    }
}
