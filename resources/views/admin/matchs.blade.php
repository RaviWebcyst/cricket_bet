@extends('layouts.admin_app')
   
@section('content')

<section class="content ">
    <div class="container-fluid">
      
      <!-- /.row -->
      <div class="row pt-5">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Matches</h3>

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
                    <th>Team A Back</th>
                    <th>Team A Lay</th>
                    <th>Team B Back</th>
                    <th>Team B Lay</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($matchs))
                      @foreach ($matchs as $key=>$match)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$match->team_a_back}}</td>
                            <td>{{$match->team_a_lay}}</td>
                            <td>{{$match->team_b_back}}</td>
                            <td>{{$match->team_b_lay}}</td>
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