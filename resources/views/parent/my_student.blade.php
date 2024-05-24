<style>
    .table th,
    .table td {
        white-space: nowrap; /* Prevent text wrapping */
    }

    /* Adjust column width as needed */
    .table th:nth-child(1),
    .table td:nth-child(1) {
        width: 80px; /* Adjust width for Profile Pic column */
    }
</style>

@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Student</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Student</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- Table Headers -->
                            <th>Profile Pic</th> <!-- Image -->
                            <th>Student Name</th> <!-- Text -->
                            <th>Email</th> <!-- Email -->
                            <th>Admission Number</th> <!-- Numeric -->
                            <th>Roll Number</th> <!-- Numeric -->
                            <th>Class</th> <!-- Text -->
                            <th>Gender</th> <!-- Text -->
                            <th>Date of Birth</th> <!-- Date -->
                            <th>Caste</th> <!-- Text -->
                            <th>Religion</th> <!-- Text -->
                            <th>Mobile Number</th> <!-- Phone Number -->
                            <th>Admission Date</th> <!-- Date -->
                            <th>Blood Group</th> <!-- Text -->
                            <th>Height</th> <!-- Numeric -->
                            <th>Weight</th> <!-- Numeric -->
                            <th>Created Date</th> <!-- Date -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getRecord as $value)
                        <tr>
                            <!-- Table Data -->
                            <td>
                                @if(!empty($value->getProfile()))
                                <img src="{{ $value->getProfile() }}" style="height: 50px; width: 50px; border-radius: 50px;">
                                @endif
                            </td>
                            <td>{{ $value->name }} {{ $value->last_name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->admission_number }}</td>
                            <td>{{ $value->roll_number }}</td>
                            <td>{{ $value->class_name }}</td>
                            <td>{{ $value->gender }}</td>
                            <td>
                                @if(!empty($value->date_of_birth))
                                {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                                @endif
                            </td>
                            <td>{{ $value->caste }}</td>
                            <td>{{ $value->religion }}</td>
                            <td>{{ $value->mobile_number }}</td>
                            <td>
                                @if(!empty($value->admission_date))
                                {{ date('d-m-Y', strtotime($value->admission_date)) }}
                                @endif
                            </td>
                            <td>{{ $value->blood_group }}</td>
                            <td>{{ $value->height }}</td>
                            <td>{{ $value->weight }}</td>
                            <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                            <td style="width: 500px">
                                <a class="btn btn-success btn-sm" href="{{ url('parent/my_student/subject/'.$value->id)}}">Subject</a>
                                <a class="btn btn-primary btn-sm" href="{{ url('parent/my_student/exam_timetable/'.$value->id)}}">Exam Timetable</a>
                                <a class="btn btn-primary btn-sm" href="{{ url('parent/my_student/exam_result/'.$value->id)}}">Exam Result</a>
                                <a class="btn btn-primary btn-sm" href="{{ url('parent/my_student/attendance/'.$value->id)}}">Attendance</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.content-wrapper -->

@endsection
