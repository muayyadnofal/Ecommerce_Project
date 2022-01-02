<?php

namespace App\Traits\EloquentTraits;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

trait Find
{
    public function findById($model, $id)
    {
        return $model::find($id);
    }

    public function findByName($table, $column, $order)
    {
        $id = DB::table($table)->where($column, $order)->value('id');
        return $this->findById(Category::class, $id);
    }
}
