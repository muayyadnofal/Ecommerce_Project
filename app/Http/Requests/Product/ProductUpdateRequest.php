<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $current_date = Carbon::now()->format('Y-m-d');
        return [
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required|max:10',
            'amount' => 'required',
            'image' => 'required|file|image:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'date_1' => "required|date|after:{$current_date}",
            'discount_1' => 'required|max:2',
            'date_2' => "required|date|after:date_1",
            'discount_2' => 'required|max:2',
            'date_3' => "required|date|after:date_2",
            'discount_3' => 'required|max:2',
        ];
    }
}
