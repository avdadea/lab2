@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Exam Results</h1>
                </div>
            </div>
        </div>
    </section>

<section class="content">
 <div class="container-fluid">
    <div class="row">

        @foreach($getRecord as $value)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$value['exam_name']}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Class Work</th>
                                <th>Home Work</th>
                                <th>Exam</th>
                                <th>Total Score</th>
                                <th>Full Mark</th>
                                <th>Passing Mark</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($value['subject'] as $exam)
                        <tr>
                        <td>{{ $exam['subject_name']}}</td>
                        <td>{{ $exam['class_work']}}</td>
                        <td>{{ $exam['home_work']}}</td>
                        <td>{{ $exam['exam']}}</td>
                        <td>{{ $exam['total_score']}}</td>
                        <td>{{ $exam['full_marks']}}</td>
                        <td>{{ $exam['passing_mark']}}</td>
                       
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        @endforeach
        </div>
    </div>
    </section>
</div>

@endsection
