@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
    <h1>Add New Student</h1>

    <form action="{{ route('student.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="form-group mb-3">
            <label for="birth_date">Birth Date</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
        </div>

        <div class="form-group mb-3">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option selected disabled hidden>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="course" class="form-label">Course</label>
            <select name="course" id="course" class="form-control" required>
                <option selected disabled hidden>Select Course</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="scholarship">Scholarship</label>
            <input type="number" class="form-control" id="scholarship" name="scholarship" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Student</button>
        <a href="{{ route('student.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
