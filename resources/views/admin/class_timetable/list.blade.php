@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Class Timetable List</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Search Class Timetable</h3>
                </div>
                
                <form method="GET" action="{{ url('admin/class_timetable/list') }}">
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-3">
                                <label>Class Name</label>
                                <select class="form-control getClass" name="class_id" required>
                                    <option value="">Select</option>
                                    @foreach($getClass as $class)
                                    <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Subject Name</label>
                                <select class="form-control getSubject" name="subject_id" required>
                                    <option value="">Select</option>
                                    @if(!empty($getSubject))
                                        @foreach($getSubject as $subject)
                                        <option {{ (Request::get('subject_id') == $subject->subject_id) ? 'selected' : '' }} value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                <a href="{{ url('admin/class_timetable/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </form>
            </div>

            @if(!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Class Timetable</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room Number</th>
                            </tr>
                        </thead>
                       
                        <tbody>
                           @foreach($week as $value)
                           <tr>
                            <th>{{ $value['week_name'] }}</th>
                            <td>
                                <input type="time" name="start_time" class="form-control">
                            </td>
                            <td>
                                <input type="time" name="end_time" class="form-control">
                            </td>
                            <td>
                                <input type="text" style="width:200px" name="room_number" class="form-control">
                            </td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>

                    <div style="text-align: center; padding:20px;">
                    <button class="btn btn-primary">Submit</button>
                    </div>

                </div><!-- /.card-body -->
            </div>
            @endif
        </div>
    </div><!-- /.row -->
</div><!-- /.content-wrapper -->

@endsection

@section('script')

<script type="text/javascript">
    $('.getClass').change(function() {
        var class_id = $(this).val();
        $.ajax({
            url: "{{ url('admin/class_timetable/get_subject') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                class_id: class_id,
            },
            dataType: "json",
            success: function(response) {
                $('.getSubject').html(response.html);
            },
        });
    });
</script>

@endsection
