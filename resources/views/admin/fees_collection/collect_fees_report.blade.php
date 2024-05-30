@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Collect Fees Report</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Collect Fees Report</h3>
                        </div>

                        <form method="get" action="">

                            <div class="card-body">
                                <div class="row">
                                <div class="form-group col-md-2" name="student_id">
                                        <label>Student ID</label>
                                        <input type="text" class="form-control" placeholder="Student ID" value= "{{ Request::get('student_id')}}"  name="student_id">
                                    </div>
                                    
                             
                                    <div class="form-group col-md-2" name="student_name">
                                        <label>Student Name</label>
                                        <input type="text" class="form-control" placeholder="Student Name" value= "{{ Request::get('student_name')}}"  name="student_name">
                                    </div>


                                   
                                <div class="form-group col-md-2" name="student_last_name">
                                        <label>Student Last Name</label>
                                        <input type="text" class="form-control" placeholder="Student Last Name" value= "{{ Request::get('student_last_name')}}"  name="student_last_name">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>Class</label>
                                        <select class="form-control" name="class_id">
                                            <option value="">Select</option>
                                            @foreach ($getClass as $class)
                                            <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Start Created Date</label>
                                        <input type="date" class="form-control" value= "{{ Request::get('start_created_date')}}"  name="start_created_date">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>End Created Date</label>
                                        <input type="date" class="form-control" value= "{{ Request::get('end_created_date')}}"  name="end_created_date">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label>Payment Type</label>
                                        <select class="form-control" name="payment_type">
                                            <option value="">Select</option>
                                            <option {{ (Request::get('payment_type') == 1) ? 'selected' : '' }} value="Cash">Cash</option>
                                            <option {{ (Request::get('payment_type') == 1) ? 'selected' : '' }} value="Cheque">Cheque</option>
                                            <option {{ (Request::get('payment_type') == 2) ? 'selected' : '' }} value="Paypal">Paypal</option>
                                            <option {{ (Request::get('payment_type') == 2) ? 'selected' : '' }} value="Stripe">Stripe</option>

                                        </select>
                                    </div>

                  


                                    <div class="form-group col-md-2">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                                        <a href="{{ url('admin/fees_collection/collect_fees_report') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </form>
    </div>
            <!-- general form elements -->
        @include('message')

            <!-- Admin List -->
            <div class="card">
                 <div class="card-header">
                    <h3 class="card-title">Collect Fees Report</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Class Name</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Remaining Amount</th>                                
                                <th>Payment Type</th>
                                <th>Remark</th>
                                <th>Created By</th>
                                <th>Created Date</th>

                            </tr>
                        </thead>
                        <tbody>
                        @forelse($getRecord as $value)
                        <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->student_id }}</td>
                        <td>{{ $value->student_name_first }} {{ $value->student_name_last }}</td>
                        <td>{{ $value->class_name}}</td>
                        <td>${{ number_format($value->total_amount,2) }}</td>
                        <td>${{ number_format($value->paid_amount,2) }}</td>
                        <td>${{ number_format($value->remaining_amount,2) }}</td>
                        <td>{{ $value->payment_type}}</td>
                        <td>{{ $value->remark}}</td>                       
                        <td>{{ $value->created_name}}</td>
                        <td>{{ date('d-m-Y', strtotime($value->created_at))}}</td>

                        </tr>
                        @empty
                          <tr>
                              <td colspan="100%">Record not found</td>
                          </tr>

                        @endforelse
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
@section('script')


@endsection