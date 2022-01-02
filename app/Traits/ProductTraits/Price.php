<?php

namespace App\Traits\ProductTraits;

use App\Traits\DatesTraits\CompareDates;

trait Price
{
    use CompareDates;

    public function modifyPrice($price, $request)
    {
        $modifiedPrice = $price;
        if ($this->compareWithCurrentDate($request->date_1)) {
            $modifiedPrice = round((1 - ($request->discount_1 / 100)) * $price);
        }
        if ($this->compareWithCurrentDate($request->date_2)) {
            $modifiedPrice = round((1 - ($request->discount_2 / 100)) * $price);
        }
        if ($this->compareWithCurrentDate($request->date_3)) {
            $modifiedPrice = round((1 - ($request->discount_3 / 100)) * $price);
        }
        return $modifiedPrice;
    }
}
