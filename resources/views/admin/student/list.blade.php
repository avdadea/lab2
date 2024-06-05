@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student List (Total : {{$getRecord->total()}})</h1>
                </div>

                <div class="col-sm-6" style="text-align: right; ">
                    <a href="{{url('admin/student/add')}}" class="btn btn-primary">Add New Student</a>
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
                    <h3 class="card-title">Search Student</h3>
                </div>

                <form method="get" action="">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="Name">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Last Name</label>
                                <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name" placeholder="Last Name">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ Request::get('email') }}" name="email" placeholder="Email">
                            </div>
                            
                            <div class="form-group col-md-2">
                                <label>Admission Number	</label>
                                <input type="text" class="form-control" value="{{ Request::get('admission_number') }}" name="admission_number" placeholder="Admission Number">
                            </div>
                          

                            <div class="form-group col-md-2">
                                <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                <a href="{{ url('admin/student/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </form>
            </div>






           
        @include('message')

            <!-- Admin List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="overflow: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile Pic</th>
                                <th>Student Name</th>
                                <th>Parent Name</th>
                                <th>Email</th>
                                <th>Admission Number</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Mobile Number</th>
                                <th>Admission Date</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($getRecord as $value)
                           <tr>
                            <td>{{  $value->id  }}</td>
                            <td>
                                @if(!empty($value->getProfileDirect()))
                                    <img src="{{ $value->getProfileDirect() }}" style="height: 50px; width: 50px; border-radius: 50px;">
                                @endif
                            </td>

                            
                            
                            <td>{{  $value->name  }}  {{  $value->last_name  }}</td>
                            <td>{{  $value->parent_name  }}  {{  $value->parent_last_name  }}</td>
                            <td>{{  $value->email  }}</td>
                            <td>{{  $value->admission_number  }}</td>
                            <td>{{  $value->class_name  }}</td>
                            <td>{{  $value->gender  }}</td>
                            <td>
                                @if(!empty($value->date_of_birth))
                                {{  date('d-m-Y', strtotime($value->date_of_birth))  }}
                                @endif
                            </td>
                            <td>{{  $value->mobile_number  }}</td>
                            <td>
                                @if(!empty($value->admission_date))
                                {{  date('d-m-Y', strtotime($value->admission_date))  }}
                                @endif
                           </td>
                            <td>{{ ($value->status==0) ? 'Active':'Inactive'}}


                            <!-- <td>
                            @if($value->status == 0)
                            Active
                            @else
                            Inactive
                            @endif
                            </td> -->
                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                            <td style="min-width:270px;">
                            <a href="{{ url('admin/student/edit/'.$value->id )}}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ url('admin/student/delete/'.$value->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success btn-sm">Send Message</a>

                            </td>

                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                    <div style="padding: 10px; float: right;">
                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.content-wrapper -->

@endsection
