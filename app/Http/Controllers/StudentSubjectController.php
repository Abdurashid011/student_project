<?php

namespace App\Http\Controllers;

use App\Models\StudentSubject;
use Illuminate\Http\RedirectResponse;

class StudentSubjectController extends Controller
{
    public function destroy(int $student_id, int $subject_id): RedirectResponse
    {
        StudentSubject::query()->where('subject_id', $subject_id)->where('student_id', $student_id)->delete();
        return redirect()->back();
    }

    public function store(int $student_id): RedirectResponse
    {
        $subject_id = request('subject_id');

        StudentSubject::query()->create([
            'student_id' => $student_id,
            'subject_id' => $subject_id,
        ]);
        return redirect()->back();
    }
}
