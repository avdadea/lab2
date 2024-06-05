@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Parent</h1>
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
                    <input type="text" class="form-control" value="{{ old('name', $getRecord->name) }}" name="name" required placeholder="First Name">
                    <div style="color:red"> {{$errors->first('name') }}</div>
                </div>

                <div class="form-group col-md-6">
                    <label>Last Name<span style="color : red;">*</span></label>
                    <input type="text" class="form-control" value="{{ old('last_name', $getRecord->last_name) }}" name="last_name" required placeholder="Last Name">
                    <div style="color:red"> {{$errors->first('last_name') }}</div>
                </div>

               
                <div class="form-group col-md-6">
                  <label>Gender<span style="color: red;">*</span></label>
                 <select class="form-control" required name="gender">
                      <option value="">Select Gender</option>
                      <option value="Male" {{ old('gender', $getRecord->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                      <option value="Female" {{ old('gender', $getRecord->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                      <option value="Other" {{ old('gender', $getRecord->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                 </select>
                 <div style="color:red">{{ $errors->first('gender') }}</div>
                 </div>

                <div class="form-group col-md-6">
                    <label>Occupation<span style="color : red;"></span></label>
                    <input type="text" class="form-control" value="{{ old('occupation', $getRecord->occupation) }}" name="occupation" placeholder="Occupation">
                    <div style="color:red"> {{$errors->first('occupation') }}</div>
                </div>

               
                <div class="form-group col-md-6">
                    <label>Mobile Number<span style="color : red;"></span></label>
                    <input type="text" class="form-control" required value="{{ old('mobile_number', $getRecord->mobile_number) }}" name="mobile_number" placeholder="Mobile Number">
                    <div style="color:red"> {{$errors->first('mobile_number') }}</div>
                </div>

                <div class="form-group col-md-6">
                    <label>Address<span style="color : red;">*</span></label>
                    <input type="text" class="form-control" required value="{{ old('address', $getRecord->address) }}" name="address" placeholder="Address">
                    <div style="color:red"> {{$errors->first('address') }}</div>
                </div>

                
                <div class="form-group col-md-6">
                    <label>Profile Picture<span style="color : red;"></span></label>
                    <input type="file" class="form-control" name="profile_picture">
                    <div style="color:red"> {{$errors->first('profile_picture') }}</div>
                    @if(!empty($getRecord->getProfile()))
                        <img src="{{$getRecord->getProfile()}}" style="width: auto;height: 50px;">
                    @endif
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

                <div class="form-group">
                    <label>Email<span style="color : red;">*</span></label>
                    <input type="email" class="form-control" value="{{ old('email',$getRecord->email) }}" name="email" required  placeholder="Email">
                  <div style="color:red"> {{$errors->first('email') }}</div>
                  </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password<span style="color : red;"></span></label>
                    <input type="text" class="form-control" name="password"  placeholder="Password">
                    <p>Do you want to change your password? If yes, please add a new password!</p>
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
