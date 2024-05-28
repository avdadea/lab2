@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Class Assigned to Teacher</h1>
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
            <div class="card card-primary">
              <form method="post" action="">
              {{ csrf_field()}}

                <div class="card-body">
                <div class="form-group">
                    <label>Class Name</label>
                    <select class="form-controller" name="class_id" required>
                        <option value="">Select Class</option>
@foreach($getClass as $class)
<option {{ ($getRecord->class_id==$class->id) ? 'selected':''}} value="{{ $class->id }}">{{ $class->name }}</option>

@endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Teacher Name</label>
                    
@foreach($getTeacher as $teacher)
<div>
<label style="font-weight: normal;">
  @php
    $checked='';
  @endphp

  @foreach($getAssignTeacherID as $teacherID)
    @if($teacherID->teacher_id == $teacher->id)
       @php
          $checked='checked';
       @endphp
    @endif
  @endforeach
<input {{ $checked }} type="checkbox" value="{{ $teacher->id }}" name="teacher_id[]"> {{ $teacher->name }} {{ $teacher->last_name }}
</label>
</div>
@endforeach
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-controller" name="status">
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>

                    </select>
                </div>
              
                <div class="form-group col-md-6">
                    <label>Status<span style="color : red;">*</span></label>
                    <select class="form-control" required name="status"> 
                        <option value="">Select Status</option>
                        <option {{ (old('status',$getRecord->status) ==0) ? 'selected' : '' }} value="0">Active</option>
                        <option {{ (old('status',$getRecord->status) ==1) ? 'selected' : '' }} value="1">Inactive</option>
                    </select>
                    <div style="color:red"> {{$errors->first('status') }}</div>
                </div>
              
                 

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
 
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


@endsection
