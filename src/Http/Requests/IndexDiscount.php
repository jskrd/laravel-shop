<?php

namespace Jskrd\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexDiscount extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required|string|exists:discounts,code',
        ];
    }
}
