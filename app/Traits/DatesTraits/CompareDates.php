<?php

namespace App\Traits\DatesTraits;

use Illuminate\Support\Carbon;

trait CompareDates
{
    public function compareWithCurrentDate($date): bool
    {
        $now = Carbon::now()->format('Y/m/d');
        $user_date = Carbon::create($date)->format('Y/m/d');
        return $now >= ($user_date);
    }
}
