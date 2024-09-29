@extends('layouts.app')

@section('title', 'Student List')

@section('content')

    <h1>Search Students</h1>
    <div class="d-flex justify-content-between mb-3">
        <form action="{{ route('search') }}" method="GET" class="me-2" style="flex: 1;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search"
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <a href="{{ route('student.create') }}" class="btn btn-success">Add New Student</a>
    </div>

    @if ($students->count() > 0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Birth Date</th>
                <th>Course</th>
                <th>Scholarship</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->birth_date }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->scholarship }}</td>
                    <td>{{ ucfirst($student->gender) }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->created_at }}</td>
                    <td class="d-flex">
                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                        <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display:inline;">
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
        <p>No students available.</p>
    @endif
@endsection
