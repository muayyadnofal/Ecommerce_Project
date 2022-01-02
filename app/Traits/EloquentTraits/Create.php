<?php

namespace App\Traits\EloquentTraits;

trait Create
{
    public function create($model, $request) {
        return $model::create($request);
    }
}
