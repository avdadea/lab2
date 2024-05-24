@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Attendance</h1>
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
                            <h3 class="card-title">Search Student Attendance</h3>
                        </div>

                        <form method="get" action="">

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Class</label>
                                        <select class="form-control" name="class_id" id="getClass" required required>
                                            <option value="">Select</option>
                                            @foreach ($getClass as $class)
                                            <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Attendance Date</label>
                                        <input type="date" class="form-control" id="getAttendanceDate" value= "{{ Request::get('attendance_date')}}" required name="attendance_date">
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{ url('admin/attendance/student') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </form>
                    </div>
                    @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Student List</h3>
                        </div>
                        <!-- /.card-header -->
                         <div class="card-body p-0" style="overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Attendance</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($getStudent) && !empty($getStudent->count()))
                                  @foreach ($getStudent as $value)   
                                  @php     
                                    $attendance_type='';
                                    $getAttendance=$value->getAttendance($value->id,Request::get('class_id'), Request::get('attendance_date'));
                                  if(!empty($getAttendance->attendance_type))
                                  {
                                      $attendance_type=$getAttendance->$attendance_type;
                                  }
                                  
                                  @endphp                        
                                    <tr>
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->name}} {{$value->last_name}}</td>
                                        <td>
                                            <label style="margin-right: 10px;">
                                               <input value="1" type="radio" {{ ($attendance_type == '1') ? 'checked' : '' }} id="{{ $value->id }}" class="SaveAttendance" name="attendance{{ $value->id }}">Present
                                            </label>
                                            <label style="margin-right: 10px;">
                                               <input value="2" type="radio" {{ ($attendance_type == '2') ? 'checked' : '' }} id="{{ $value->id }}" class="SaveAttendance" name="attendance{{ $value->id }}">Absent
                                            </label>

                                        </td>
                                    </tr>
                                    @endforeach

                                    @endif
                                </tbody>
                            </table>
                         </div>
                       </div>
                    @endif
                    <!-- Admin List -->
                
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section>
</div><!-- /.content-wrapper -->

@endsection

@section('script')

<script type="text/javascript">
$(document).ready(function() {
    // Retrieve and set the selected attendance from localStorage on page load
    $('.SaveAttendance').each(function() {
        var student_id = $(this).attr('id');
        var storedAttendance = localStorage.getItem('attendance_' + student_id);
        if (storedAttendance !== null) {
            $(this).prop('checked', storedAttendance === $(this).val());
        }
    });

    // Handle change event for attendance radio buttons
    $('.SaveAttendance').change(function(e) {
        var student_id = $(this).attr('id');
        var attendance_type = $(this).val();
        var class_id = $('#getClass').val();
        var attendance_date = $('#getAttendanceDate').val();

        // Save the selected attendance to localStorage
        localStorage.setItem('attendance_' + student_id, attendance_type);

        // Make AJAX request to save attendance
        $.ajax({
            type: "POST",
            url: "{{ url('admin/attendance/student/save') }}",
            data: {
                _token: '{{ csrf_token() }}',
                student_id: student_id,
                attendance_type: attendance_type,
                class_id: class_id,
                attendance_date: attendance_date,
            },
            dataType: "json",
            success: function(data) {
                alert(data.message);
            },
            error: function(xhr, status, error) {
                console.error('Error saving attendance:', error);
                alert('An error occurred while saving attendance. Please try again.');
            }
        });
    });
});
</script>

@endsection
