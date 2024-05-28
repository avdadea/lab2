@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Admin</h1>
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
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" required  placeholder="Email">
                  <div style="color:red"> {{$errors->first('email') }}</div>
                  </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="Password">
                </div>
                 
                <div class="form-group">
                    <label>Profile Picture<span style="color : red;"></span></label>
                    <input type="file" class="form-control" name="profile_picture">
                    <div style="color:red"> {{$errors->first('profile_picture') }}</div>
                </div>
                 

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
 
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


@endsection
