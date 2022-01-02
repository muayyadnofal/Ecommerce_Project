<?php

namespace App\src\Seller\Profile;

use App\Http\Resources\Profile\Admin\AdminProfileResource;
use App\Models\Admin;
use App\Traits\EloquentTraits\Find;
use App\Traits\HttpTraits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class GetProfile
{
    use HttpResponse;
    use Find;

    public function getSellerInfo(): \Illuminate\Http\Response
    {
        $seller_id = Auth::user()->id;
        $seller = $this->findById(Admin::class, $seller_id);
        return self::returnData("{$seller->name}:", new AdminProfileResource($seller), "{$seller->name} information");
    }
}
