<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        $course = $this->route('course');
        $lesson = $this->route('lesson');
        if (!$user) return false;
        if ($user->isAdmin()) return true;
        if ($user->isInstructor()) {
            // course may be available via route param or via lesson
            $c = $course ?? ($lesson ? $lesson->course : null);
            return $c && $c->instructor_id === $user->id;
        }
        return false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'video' => ['nullable','file','mimetypes:video/mp4,video/x-msvideo,video/quicktime,video/x-ms-wmv,video/mpeg','max:512000'],
            'video_url' => ['nullable', 'string'],
            'is_free' => ['nullable', 'boolean'],
            'content' => ['nullable', 'string'],
        ];
    }
}
