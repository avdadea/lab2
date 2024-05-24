@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam Timetable <span style="color:blue;">({{ $getStudent->name}} {{ $getStudent->last_name}})</span></h1>
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
                                <th>Subject</th>
                                <th>Class Work</th>
                                <th>Home Work</th>
                                <th>Exam</th>
                                <th>Total Score</th>
                                <th>Passing Mark</th>                                
                                <th>Full Mark</th>
                                <th>Result</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                        @php
                        $total_score=0;
                        $full_marks=0;  
                        $result_validation=0;                      
                        @endphp
                        @foreach($value['subject'] as $exam)
                        @php
                        $total_score=$total_score + $exam['total_score'];
                        $full_marks=$full_marks + $exam['full_marks'];
                        @endphp

                        <tr>
                        <td style="width: 300px">{{ $exam['subject_name']}}</td>
                        <td>{{ $exam['class_work']}}</td>
                        <td>{{ $exam['home_work']}}</td>
                        <td>{{ $exam['exam']}}</td>
                        <td>{{ $exam['total_score']}}</td>
                        <td>{{ $exam['passing_mark']}}</td>
                        <td>{{ $exam['full_marks']}}</td>
                       
                       <td> 
                        @if($exam['total_score']>=$exam['passing_mark'])
                            <span style="color: green;"><b>Passed</b></span> 
                        @else
                            @php
                           $result_validation=1
                            @endphp
                            <span style="color: red;"><b>Failed<b></span>                         
                        @endif
                       </td>
                        </tr>
                        @endforeach
                        <tr>
                        <td colspan="2"><b>Grand Total: {{$total_score}}/{{ $full_marks}} </b></td>
                        
                        <td colspan="2">
                        @php
                       $percentage=($total_score * 100)/ $full_marks;
                       $getGrade = App\Models\MarksGradeModel::getGrade($percentage); 

                       @endphp    
                             <b>Percentage: {{ round($percentage,2) }}%</b></td>
                             <td colspan="2"><b>Grade {{ $getGrade}} </b></td>

                        <td colspan="3"><b>Result: 
                            @if($result_validation==0) 
                                <span style="color: green;"><b>Passed</b></span> 
                            @else 
                             <span style="color: red;"><b>Failed<b></span>
                            @endif
                            </b></td>
                     
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        @endforeach
        </div>
    </section>
</div>

@endsection
