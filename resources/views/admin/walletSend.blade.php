@extends('layouts.admin_app')
   
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row pt-5">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Send Amount</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('admin.walletStore',$id)}}" method="post">
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="">Amount</label>
                  <input type="text" class="form-control"  name="amount" placeholder="Enter Amount">
                </div>
                
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->

        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
@endsection