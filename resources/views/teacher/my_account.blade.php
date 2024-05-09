@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Account</h1>
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
              <form method="post" action="" enctype="multipart/form-data">
              {{ csrf_field()}}

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>First Name<span style="color : red;">*</span></label>
                            <input type="text" class="form-control" value="{{ old('name',$getRecord->name)}}" name="name" required placeholder="First Name">
                            <div style="color:red"> {{$errors->first('name') }}</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Last Name<span style="color : red;">*</span></label>
                            <input type="text" class="form-control" value="{{ old('last_name',$getRecord->last_name) }}" name="last_name" required placeholder="Last Name">
                            <div style="color:red"> {{$errors->first('last_name') }}</div>
                        </div>


                        <div class="form-group col-md-6">
                            <label>Gender<span style="color : red;">*</span></label>
                            <select class="form-control" required name="gender"> 
                                <option value="">Select Gender</option>
                                <option {{ (old('gender',$getRecord->gender) =='Male') ? 'selected' : '' }} value="Male">Male</option>
                                <option {{ (old('gender',$getRecord->gender) =='Female') ? 'selected' : '' }}value="Female">Female</option>
                                <option {{ (old('gender',$getRecord->gender) =='Other') ? 'selected' : '' }}value="Other">Other</option>
                            </select>
                            <div style="color:red"> {{$errors->first('gender') }}</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Date of Birth<span style="color : red;">*</span></label>
                            <input type="date" class="form-control required" value="{{ old('date_of_birth',$getRecord->date_of_birth) }}" name="date_of_birth">
                            <div style="color:red"> {{$errors->first('date_of_birth') }}</div>
                        </div>


                        <div class="form-group col-md-6">
                            <label>Mobile Number<span style="color : red;"></span></label>
                            <input type="text" class="form-control" value="{{ old('mobile_number',$getRecord->mobile_number) }}" name="mobile_number" placeholder="Mobile Number">
                            <div style="color:red"> {{$errors->first('mobile_number') }}</div>
                        </div>
                                       
                        <div class="form-group col-md-6">
                            <label>Marital Status<span style="color : red;"></span></label>
                            <input type="text" class="form-control" value="{{ old('marital_status',$getRecord->marital_status) }}" name="marital_status" placeholder="Marital Status">
                            <div style="color:red"> {{$errors->first('marital_status') }}</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Profile Pic<span style="color : red;"></span></label>
                            <input type="file" class="form-control" name="profile_picture">
                            <div style="color:red"> {{$errors->first('profile_picture') }}</div>
                            @if(!empty($getRecord->getProfile()))
                                <img src="{{$getRecord->getProfile()}}" style="width: auto;height: 50px;">
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label>Current Address<span style="color : red;"></span></label>
                            <input type="text" class="form-control" name="address" value="{{ old('address',$getRecord->address) }}">
                            <div style="color:red"> {{$errors->first('address') }}</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Permanent Address<span style="color : red;"></span></label>
                            <input type="text" class="form-control" name="permanent_address" value="{{ old('permanent_address',$getRecord->permanent_address) }}" >
                            <div style="color:red"> {{$errors->first('permanent_address') }}</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Qualification<span style="color : red;"></span></label>
                            <input type="text" class="form-control" name="qualification" value="{{ old('qualification',$getRecord->qualification) }}">
                            <div style="color:red"> {{$errors->first('qualification') }}</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Work Experience<span style="color : red;"></span></label>
                            <input type="text" class="form-control" name="work_experience" value="{{ old('work_experience',$getRecord->work_experience) }}">
                            <div style="color:red"> {{$errors->first('work_experience') }}</div>
                        </div>



                    </div> <!-- /.row -->

                    <div class="form-group">
                        <label>Email<span style="color : red;">*</span></label>
                        <input type="email" class="form-control" value="{{ old('email',$getRecord->email) }}" name="email" required  placeholder="Email">
                        <div style="color:red"> {{$errors->first('email') }}</div>
                    </div>


                </div> <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div> <!-- /.col-md-12 -->
        </div> <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>

@endsection