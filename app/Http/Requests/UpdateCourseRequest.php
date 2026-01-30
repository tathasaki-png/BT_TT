<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        if ($user->isAdmin()) return true;
        
        $course = $this->route('course');
        return $user->isInstructor() && $course && $course->instructor_id === $user->id;
    }

    public function rules(): array
    {
        $course = $this->route('course');
        $ignore = $course instanceof \App\Models\Course ? $course->id : $course;

        return [
            'title' => ['required','string','max:255', Rule::unique('courses','title')->ignore($ignore)],
            'thumbnail' => ['nullable','image','max:2048'],
            'price' => ['required','integer','min:0'],
            'discount_percent' => ['nullable','integer','between:0,100'],
            'short_description' => ['nullable','string','max:500'],
            'content' => ['nullable','string'],
            'status' => ['required','in:draft,published'],
            'instructor_id' => ['required','exists:users,id'],
            'category_id' => ['required','exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề khóa học không được để trống.',
            'title.unique' => 'Tiêu đề khóa học này đã tồn tại.',
            'price.required' => 'Giá khóa học không được để trống.',
            'price.numeric' => 'Giá khóa học phải là chữ số.',
            'instructor_id.required' => 'Vui lòng chọn giảng viên.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'thumbnail.image' => 'Ảnh bìa phải là định dạng hình ảnh.',
            'thumbnail.max' => 'Ảnh bìa không được vượt quá 2MB.',
        ];
    }
}
