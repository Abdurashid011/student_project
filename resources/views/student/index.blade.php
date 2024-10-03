@extends('layouts.app')

@section('title', 'Student List')

@section('content')

    <h1>Search Students</h1>

    <div class="mb-3">
        <div class="row">
            <div class="col-md-9">
                <!-- Search qismi -->
                <form action="{{ route('search') }}" method="GET" class="d-flex flex-wrap gap-2">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" name="search" class="form-control form-control-lg" placeholder="Search"
                               value="{{ request('search') }}">
                        <select name="search_by" class="form-select form-select-lg">
                            <option selected disabled hidden>Select</option>
                            <option value="first_name">First Name</option>
                            <option value="last_name">Last Name</option>
                            <option value="birth_date">Birth Date</option>
                            <option value="course">Course</option>
                            <option value="scholarship">Scholarship</option>
                            <option value="gender">Gender</option>
                            <option value="email">Email</option>
                            <option value="address">Address</option>
                            <option value="created_at">Created At</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="number" name="min_scholarship" class="form-control form-control-lg"
                               placeholder="Min Scholarship" value="{{ request('min_scholarship') }}">
                        <input type="number" name="max_scholarship" class="form-control form-control-lg"
                               placeholder="Max Scholarship" value="{{ request('max_scholarship') }}">
                    </div>

                    <button class="btn btn-primary btn-lg" type="submit">Search</button>
                </form>
            </div>

            <div class="col-md-3 text-md-end mt-2 mt-md-0">
                <a href="{{ route('student.create') }}" class="btn btn-success btn-lg">Add New Student</a>
            </div>
        </div>
    </div>

    @if ($students->count() > 0)
        <table class="table table-striped table-sm">
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
                    <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
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
                        <form action="{{ route('student.destroy', $student->id) }}" method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $students->previousPageUrl() }}">Previous</a>
                </li>
                @for ($i = 1; $i <= $students->lastPage(); $i++)
                    <li class="page-item {{ $i == $students->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $students->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $students->nextPageUrl() }}">Next</a>
                </li>
            </ul>
        </nav>

    @else
        <p>No students available.</p>
    @endif
@endsection
