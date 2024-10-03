@extends('layouts.app')

@section('title', 'Student Details')

@section('content')

    <div class="container mt-5">
        <h1>Student Details</h1>

        <div class="card mb-4">
            <div class="card-header">
                Student Information
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $student->first_name }} {{ $student->last_name }}</h5>
                <p class="card-text"><strong>Birth Date:</strong> {{ $student->birth_date }}</p>
                <p class="card-text"><strong>Course:</strong> {{ $student->course }}</p>
                <p class="card-text"><strong>Scholarship:</strong> {{ $student->scholarship }}</p>
                <p class="card-text"><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $student->email }}</p>
                <p class="card-text"><strong>Address:</strong> {{ $student->address }}</p>
            </div>
        </div>

        <h2>Enrolled Subjects</h2>

        <!-- Subject qo'shish buttoni -->
        <form action="{{ route('subject.create', ['student_id' => $student->id]) }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <select name="subject_id" class="form-control">
                    @foreach ($allSubjects as $subject)
                        <option selected disabled hidden>Select</option>
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-success">Add Subject</button>
                </div>
            </div>
        </form>

        @if ($student->subjects->count() > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($student->subjects as $index => $subject)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>
                            <form action="{{ route('subject.delete', [$student->id, $subject->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>This student is not enrolled in any subjects yet.</p>
        @endif

        <a href="{{ route('student.index') }}" class="btn btn-secondary mt-3">Back to Student List</a>
    </div>

@endsection
