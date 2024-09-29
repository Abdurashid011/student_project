<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): View|Factory|Application
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }


    public function create(): View|Factory|Application
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'course' => 'required|integer',
            'scholarship' => 'required|integer',
        ]);

        Student::create($validatedData);

        return redirect()->route('student.index');
    }

    public function show(Student $student): View|Factory|Application
    {
        return view('student.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id,
            'course' => 'required|integer',
            'scholarship' => 'required|integer',
        ]);

        $student->update($validatedData);

        return redirect()->route('student.index');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();
        return redirect()->route('student.index');
    }

    public function search(Request $request): View|Factory|Application
    {
        $search = request('search');

        if (strpos($search, '@email.com') !== false) {
            $students = Student::where('email', 'like', "%{$search}%")->get();
            return view('student.index', compact('students'));
        }


        if (is_numeric($search) && (int)$search <= 4 && (int)$search > 0) {
            $students = Student::when($search, function ($query, $search) {
                return $query->where('course', 'like', "$search");
            })->get();
        } elseif (is_numeric($search) && (int)$search > 1900 && (int)$search < 3000) {
            $students = Student::when($search, function ($query, $search) {
                return $query->where('birth_date', 'like', "%{$search}%");
            })->get();
        } else {
            $students = Student::when($search, function ($query, $search) {
                return $query->where('first_name', 'like', "$search")
                    ->orWhere('last_name', 'like', "$search")
                    ->orWhere('gender', 'like', "$search")
                    ->orWhere('scholarship', 'like', "$search")
                    ->orWhere('address', 'like', "%{$search}%");
            })->get();
        }

        return view('student.index', compact('students'));
    }

}
