<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        $course = $this->route('course');
        if (!$user) return false;
        if ($user->isAdmin()) return true;
        if ($user->isInstructor() && $course) {
            return $course->instructor_id === $user->id;
        }
        return false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'video' => ['nullable','file','mimetypes:video/mp4,video/x-msvideo,video/quicktime,video/x-ms-wmv,video/mpeg','max:512000','required_without:video_url'],
            'video_url' => ['nullable', 'string', 'required_without:video'],
            'is_free' => ['nullable', 'boolean'],
            'content' => ['nullable', 'string'],
        ];
    }
}
