<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $category = $this->route('category');
        $ignore = $category instanceof \App\Models\Category ? $category->id : $category;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($ignore)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
        ];
    }
}
