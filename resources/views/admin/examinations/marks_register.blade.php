@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Marks Registers</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Marks Registers</h3>
                        </div>

                        <form method="get" action="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Exam</label>
                                        <select class="form-control" name="exam_id" required>
                                            <option value="">Select</option>
                                            @foreach ($getExam as $exam)
                                            <option {{ (Request::get('exam_id') == $exam->id) ? 'selected' : '' }} value="{{ $exam->id }}">{{$exam->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Class</label>
                                        <select class="form-control" name="class_id" required>
                                            <option value="">Select</option>
                                            @foreach ($getClass as $class)
                                            <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{ url('admin/examinations/mark_registers') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </form>
                    </div>

                    <!-- Admin List -->
                    @if(!empty($getSubject) && !empty($getSubject->count()))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Marks Registers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STUDENT NAME</th>
                                        @foreach ($getSubject as $subject)
                                        <th>{{ $subject->subject_name}} <br/>
                                            ( {{$subject->subject_type}} : {{$subject->passing_mark}} / {{$subject->full_marks}})
                                        </th>
                                        @endforeach
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($getStudent) && !empty($getStudent->count()))
                                    @foreach($getStudent as $student)
                                    <form name="post" class="SubmitForm">
                                        {{ csrf_field()}}
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                                        <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">

                                        <tr>
                                            <td>{{ $student->name}} {{$student->last_name }}</td>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach ($getSubject as $subject)
                                            
                                            @php
                                            $getMark = $subject->getMark( $student->id, Request::get('exam_id'), Request::get('class_id'), $subject->subject_id);
                                            @endphp
                                            <td>
                                                <div style="margin-bottom: 10px;">  
                                                    Class work
                                                    <input type="hidden" name="mark[{{ $i }}][subject_id]" value="{{ $subject->subject_id }}">
                                                    <input type="text" name="mark[{{ $i }}][class_work]" id="class_work_{{ $student->id }}{{ $subject->subject_id }}" style="width:200px;" placeholder="Enter Mark" value="{{ !empty($getMark->class_work) ? $getMark->class_work : '' }}" class="form-control">
                                                </div>
                                                <div style="margin-bottom: 10px;">  
                                                    Home work
                                                    <input type="text" id="home_work_{{ $student->id }}{{ $subject->subject_id }}" name="mark[{{ $i }}][home_work]" style="width:200px;" placeholder="Enter Mark" value="{{ !empty($getMark->home_work) ? $getMark->home_work : '' }}"class="form-control">
                                                </div>
                                                <div style="margin-bottom: 10px;">  
                                                    Exam 
                                                    <input type="text"id="exam{{ $student->id }}{{ $subject->subject_id }}"  name="mark[{{ $i }}][exam]" style="width:200px;" placeholder="Enter Mark" value="{{ !empty($getMark->exam) ? $getMark->exam : '' }}" class="form-control">
                                                </div>

                                                <div style="margin-bottom:10px;"> 
                                               <button type="button" class="btn btn-primary SaveSingleSubject" id="{{ $student->id }}" data-val="{{ $subject->subject_id }}"
                                                 data-exam="{{ Request::get('exam_id') }}" data-class="{{ Request::get('class_id') }}">Save</button>
                                                </div>
                                            </td>
                                            @php
                                            $i++;
                                            @endphp
                                            @endforeach
                                            <td>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </td>
                                        </tr>
                                    </form>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                    @endif

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section>
</div><!-- /.content-wrapper -->

@endsection

@section('script')

<script type="text/javascript">
    $('.SubmitForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url : "{{ url('admin/examinations/submit_marks_register') }}",
            data : $(this).serialize(),
            dataType : "json",
            success: function(data) {
                alert(data.message);
            }
     
        });
    });


    $('.SaveSingleSubject').click(function(e){
        var student_id=$(this).attr('id');
        var subject_id=$(this).attr('data-val');
        var exam_id=$(this).attr('data-exam');
        var class_id=$(this).attr('data-class');
        var class_work=$('#class_work_'+student_id+subject_id).val();
        var home_work=$('#home_work_'+student_id+subject_id).val();
        var exam=$('#exam'+student_id+subject_id).val();



        $.ajax({
            type: "POST",
            url : "{{ url('admin/examinations/single_submit_marks_register') }}",
            data :{
                _token:'{{ csrf_token() }}',
                student_id:student_id,
                subject_id:subject_id,
                exam_id:exam_id,
                class_id:class_id,
                class_work:class_work,
                home_work:home_work,
                exam:exam

            },
            dataType : "json",
            success: function(data) {
                alert(data.message);
            }
        });
    });


</script>
@endsection
