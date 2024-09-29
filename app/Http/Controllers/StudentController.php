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
        $search = $request->input('search');
        $searchBy = $request->input('search_by');
        $minScholarship = $request->input('min_scholarship');
        $maxScholarship = $request->input('max_scholarship');

        $students = Student::query();

        if ($search && $searchBy) {
            $students->when($searchBy == 'first_name', function ($query) use ($search) {
                return $query->where('first_name', 'like', "%{$search}%");
            })->when($searchBy == 'last_name', function ($query) use ($search) {
                return $query->where('last_name', 'like', "%{$search}%");
            })->when($searchBy == 'birth_date', function ($query) use ($search) {
                return $query->where('birth_date', 'like', "%{$search}%");
            })->when($searchBy == 'course', function ($query) use ($search) {
                return $query->where('course', $search);
            })->when($searchBy == 'scholarship', function ($query) use ($search) {
                return $query->where('scholarship', 'like', "%{$search}%");
            })->when($searchBy == 'gender', function ($query) use ($search) {
                return $query->where('gender', $search);
            })->when($searchBy == 'email', function ($query) use ($search) {
                return $query->where('email', 'like', "%{$search}%");
            })->when($searchBy == 'address', function ($query) use ($search) {
                return $query->where('address', 'like', "%{$search}%");
            })->when($searchBy == 'created_at', function ($query) use ($search) {
                return $query->where('created_at', 'like', "%{$search}%");
            });
        }

        if ($minScholarship) {
            $students->where('scholarship', '>=', $minScholarship);
        }

        if ($maxScholarship) {
            $students->where('scholarship', '<=', $maxScholarship);
        }

        $students = $students->get();

        return view('student.index', compact('students'));
    }
}
