<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewRequest;
use App\src\Customer\Reviews\CreateReview;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function store(ReviewRequest $request, $id): \Illuminate\Http\Response
    {
        return (new \App\src\Customer\Reviews\CreateReview)->makeReview($request, $id);
    }
}
