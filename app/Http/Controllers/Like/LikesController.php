<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\src\Customer\Like\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function store($id): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Like\Like)->likeAndDislike($id);
    }
}
