<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'customer' => $this->customer,
            'comment' => $this->comment
        ];
    }
}
