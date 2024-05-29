@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Setting</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">

          @include('message')
            <!-- general form elements -->
            <div class="card card-primary">
              <form method="post" action="">
              {{ csrf_field()}}

                <div class="card-body">
     
                <div class="form-group">
                    <label>PayPal Email</label>
                    <input type="email" class="form-control" name="paypal_email" value="{{$getRecord->paypal_email}}" required  placeholder="PayPal Email">
                </div>


                <div class="form-group">
                    <label>Stripe Public Key</label>
                    <input type="text" class="form-control" name="stripe_key" value="{{$getRecord->stripe_key}}" >
                </div>

                <div class="form-group">
                    <label>Stripe Secret Key</label>
                    <input type="text" class="form-control" name="stripe_secret" value="{{$getRecord->stripe_secret}}">
                </div>

            </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
 
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>


@endsection
