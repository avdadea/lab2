@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Timetable  ({{ $getClass->name}}-{{ $getSubject->name}})</h1>
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
                <h3 class="card-title">
                    {{ $getClass->name}}-{{ $getSubject->name}}

                </h3>
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
                        @foreach($getRecord as $valueW)
                        <tr> 
                            <td>{{ $valueW['week_name'] }}</td>
                            <td>{{ !empty($valueW['start_time']) ? date('h:i A', strtotime($valueW['start_time'])) : '' }}</td>
                            <td>{{ !empty($valueW['end_time']) ? date('h:i A', strtotime($valueW['end_time'])) : '' }}</td>
                           
                            <td>{{ $valueW['room_number'] }}</td>
                             <td></td>

                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    </div>

                </div><!-- /.card-body -->
            </div>
    </div><!-- /.row -->
</div><!-- /.content-wrapper -->

@endsection

