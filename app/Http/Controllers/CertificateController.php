<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function generate(Course $course)
    {
        $user = Auth::user();

        // Check if user has completed the course
        $totalLessons = $course->lessons()->count();
        $completedLessons = DB::table('lesson_user')
            ->where('user_id', $user->id)
            ->whereIn('lesson_id', $course->lessons()->pluck('id')->toArray())
            ->whereNotNull('completed_at')
            ->count();

        if ($completedLessons < $totalLessons) {
            return redirect()->back()->with('error', 'Bạn cần hoàn thành tất cả các bài học để nhận chứng chỉ.');
        }

        // Check if certificate already exists
        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$certificate) {
            $certificate = Certificate::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
        }

        return $this->show($certificate);
    }

    public function show(Certificate $certificate)
    {
        // Check authorization
        if ($certificate->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('certificate.show', compact('certificate'));
    }

    public function download(Certificate $certificate)
    {
        // Check authorization
        if ($certificate->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return $this->generatePDF($certificate);
    }

    private function generatePDF(Certificate $certificate)
    {
        // Using basic HTML to PDF approach with dompdf
        $html = view('certificate.pdf', compact('certificate'))->render();

        // For now, return the view as PDF (implement dompdf if needed)
        return response($html, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="certificate-' . $certificate->slug . '.pdf"',
        ]);
    }
}
