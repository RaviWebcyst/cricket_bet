@extends('layouts.app')

@section('content')

                    <div class="container  col-md-6">
                      @if(Auth::user()->is_admin == 1)
                        <script>window.location = "{{route('admin.home')}}";</script>
                        @endif
                            <h6 class="mb-4 ">Balance: <small class="bal">{{$balance}}</small></h6>
                            <div>
                                <table class="table mt-1">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Virtual Wallet</th>
                                            <th>Back</th>
                                            <th>Lay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Team A : <span class="team_a"></span></td>
                                            <td>(+ {{$wallet_credit_a}})(- {{$wallet_debit_a}})({{$wallet_balance_a}})</td>
                                            <td id="rt_{{str_replace(".","",$team_a->back)}}" onclick="rate('{{$team_a->back}}',1)" data-id="{{$team_a->back}}">{{$team_a->back}}</td>
                                            <td id="rt_{{str_replace(".","",$team_a->lay)}}" onclick="rate('{{$team_a->lay}}',3)">{{$team_a->lay}}</td>
                                        </tr>
                                    </tbody>
                                    {{-- <thead>
                                        <tr>
                                            <th>Rate3</th>
                                            <th>Rate4</th>
                                        </tr>
                                    </thead> --}}
                                    <tbody>
                                        <tr>  
                                            <td>Team B : <span class="team_b"></span></td>
                                            <td>(+ {{$wallet_credit_b}})(- {{$wallet_debit_b}})({{$wallet_balance_b}})</td>
                                            <td id="rt_{{str_replace(".","",$team_b->back)}}" onclick="rate('{{$team_b->back}}',2)">{{$team_b->back}}</td>
                                            <td id="rt_{{str_replace(".","",$team_b->lay)}}" onclick="rate('{{$team_b->lay}}',4)">{{$team_b->lay}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>



<div class="modal fade" id="rate1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:50px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="text-danger error"></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" class="form-control"  id="val" name="value">
              {{-- <div class="col-md-12">
                <div class="text-danger error"></div>
              </div> --}}
              <div class="form-group col-md-3">
                <label> Rate</label>
                <input type="text" class="form-control"  name="rate" id="rat1">
              </div>
              <div class="form-group col-md-3">
                <label > Amount</label>
                <input type="text" class="form-control"  id="calrat1" name="amount" value="1000">
              </div>
              <div class="form-group col-md-3">
                <label > Total</label>
                <input type="text" class="form-control"  id="totalAmnt" required>
              </div>
              <div class="form-group col-md-3">
                <button type="button" class="btn btn-primary mb-2 ml-auto cal1 mt-3">Calculate</button>
                </div>
              </div>
            <div class="row">
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(1000)">1000</button></div>
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(5000)">5000</button></div>
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(10000)">10000</button></div>
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(25000)">25000</button></div>
            </div>
            <div class="row mt-2">
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(50000)">50000</button></div>
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(100000)">100000</button></div>
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(200000)">200000</button></div>
              <div class="col-md-3"><button class="btn btn-light" onclick="btn_val(500000)">500000</button></div>
            </div>

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close1" data-dismiss="modal" >Close</button>
          <button type="button" class="btn btn-success bet">Place Bet</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function rate(data,val){
      $(document).ready(function(){
       
        var data1 = data.replace(".","");
        $(".modal").attr("id","rate_"+data1);
        jQuery("#rate_"+data1).modal("show");
        var rate1 = $("#rt_"+data1).text();
        $("#rat1").val(rate1);
        $("#val").val(val);

        $(".error").text("");
        $("#totalAmnt").val("");
      });
    }
    
    function btn_val(data){
      document.getElementById("calrat1").value = data;
    }

    
  $(document).ready(function(){
    
    var val =1;
    $(".cal1").click(function(){
      var value = $("#val").val();
      var calrate = $("#calrat1").val();
      var rate = $("#rat1").val();

      $.ajax({
            url:"",
            method:"get",
            data:{
              value:value,
              calrate:calrate,
              rate:rate
            },
            success:function(data){
              console.log(data);
               team_a = data;
              
                team_a = team_a.toFixed(2);
                if(!team_a || team_a == "Infinity"){
                  team_a = 0;
                }
      

                $("#totalAmnt").val(team_a);
                
                var bal = $(".bal").text();
                $(".team_a").text(team_a);
                $(".team_b").text(calrate);

                if(calrate > bal){
                    $(".error").text("not enough balance to bet");
                    return false;
                  }

                if(value == 3){
                  $(".team_a").text(calrate);
                  $(".team_b").text(team_a);

                    if(team_a > bal){
                      $(".error").text("not enough balance to bet");
                    }
                    $(".error").text("");
                }
                if(value == 2){
                    $(".team_b").text(team_a);
                    $(".team_a").text(calrate);

                    if(calrate > bal){
                      $(".error").text("not enough balance to bet");
                    }
                }
                if(value == 4){
                  $(".team_b").text(calrate);
                  $(".team_a").text(team_a);
                  if(team_a > bal){
                      $(".error").text("not enough balance to bet");
                  }
                }
              }
      });
          
    });

    $(".close , .close1").click(function(){
        $(".team_b").text("");
        $(".team_a").text("");
    });
          $(".bet").click(function(){
            var tAmnt = $("#totalAmnt").val();
            if(tAmnt == ""){
              $(".error").text("Total amount is required");
              return false;
            }

            var betAmnt = $("#calrat1").val();

              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': "{{csrf_token()}}"
                  }
              });
              var value = $("#val").val();
              var amount = $("#calrat1").val();
            if( value == 3 || value == 4){
              var amount = $("#totalAmnt").val();
            }
              $.ajax({
                url:"{{route('bet.store')}}",
                method:"post",
                data:{
                  value:value,
                  amount:amount,
                  tAmnt:tAmnt,
                  betAmnt:betAmnt
                },  
                success:function(data){
                  console.log(data);
                  if(data.error){
                    alert(data.error);
                  }
                  $(".team_b").text("");
                  $(".team_a").text("");
                  $(".modal").modal("hide");
                }
              });
        });

    });

  </script>
@endsection
