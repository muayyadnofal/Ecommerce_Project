<?php

namespace App\Traits\AuthTraits;

trait CheckID
{
    public function checkAdminID($connectedTo, $user): bool
    {
        return $connectedTo->admin_id === $user->id;
    }
}
