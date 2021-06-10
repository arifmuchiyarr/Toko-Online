<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'users_id' => 'required|exists:users,id',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'description' => 'required',
        ];
    }
}
