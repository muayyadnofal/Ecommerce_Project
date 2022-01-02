<?php

namespace App\Traits\AuthTraits;

use App\Models\Admin;
use App\Traits\EloquentTraits\Find;
use Illuminate\Support\Facades\Auth;

trait GetUser
{
    use Find;

    public function getAuthenticatedUser($model) {
        $id = Auth::user()->id;
        return $this->findById($model, $id);
    }

}
