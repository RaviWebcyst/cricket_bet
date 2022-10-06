@extends('layouts.admin_app')
   
@section('content')

<section class="content ">
    <div class="container-fluid">
      
      <!-- /.row -->
      <div class="row pt-5">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Users</h3>
                <div class="card-tools">
                  <a href="{{route('admin.addUser')}}" class="btn btn-sm btn-info">Add User</a>
                </div>
              {{-- <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Balance</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($users))
                      @foreach ($users as $key=>$user)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->balance}}</td>
                            <td><a href="{{route('admin.walletSend',$user->id)}}" class="btn btn-sm btn-info">Send</a></td>
                          </tr>
                      @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
      
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>

@endsection