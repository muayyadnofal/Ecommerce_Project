<?php

namespace App\Traits\ProductTraits;

use App\Models\Product;
use App\Traits\EloquentTraits\Find;
use Illuminate\Support\Carbon;

trait DeleteByDate
{
    use Find;

    public function delete($date, $id)
    {
        $deleted = false;
        $now = Carbon::now()->format('Y/m/d');
        $user_date = Carbon::create($date)->format('Y/m/d');

        $product = $this->findById(Product::class, $id);

        if ($now === $user_date) {
            $product->delete();
            return true;
        }

        return false;
    }
}
