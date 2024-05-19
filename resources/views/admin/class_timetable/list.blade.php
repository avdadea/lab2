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

                <form method="get" action="">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Class Name</label>
                                <select class="form-control">
                                    <option value="">Select</option>
                                </select>
                                <input type="text" class="form-control" value="{{ Request::get('class_name') }}" name="class_name" placeholder="Class Name">
                            </div>

                            <div class="form-group col-md-3">
                                <label>Subject Name</label>
                                <input type="text" class="form-control" value="{{ Request::get('subject_name') }}" name="subject_name" placeholder="Subject Name">
                            </div>
                           

                            <div class="form-group col-md-3">
                                <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                <a href="{{ url('admin/assign_subject/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </form>
            </div>

            <!-- Admin List -->
            
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.content-wrapper -->

@endsection
