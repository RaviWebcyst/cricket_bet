<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Rating</title>
    <style>
      .modal{
        transform: translate3d(0%, 30%, 0);
      }
      .modal-backdrop.show {
          opacity: 0;
      }
    </style>
</head>
<body>

  <div class="container mt-5 col-md-6">
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

        {{-- <div class="justify-content-center mt-5">
            <div class="card">
                <div class="card-header">
                    Rates
                </div>
                
                <div class="card-body">
                    <form action="{{route('rate.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Rate1</label>
                                <input type="text" class="form-control" name="rate1" required >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Rate2</label>
                                <input type="text" class="form-control" name="rate2" required >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Rate3</label>
                                <input type="text" class="form-control" name="rate3" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Rate4</label>
                                <input type="text" class="form-control" name="rate4" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>


    <div class="modal fade" id="rate1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
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

          
          // var team_a = (rate-val)*calrate;
      
                  // var team_a = (calrate/rate)*val;
                   // team_a = Math.round(team_a);

          
            // $(".team_a").text(team_a);
            // $(".team_b").text(-calrate);

            // if(calrate > bal){
            //   $(".error").text("not enough balance to bet");
            //   return false;
            // }
          
          // if(value == 2){
          //   $(".team_b").text(team_a);
          //   $(".team_a").text(-calrate);

          //   if(calrate > bal){
          //     $(".error").text("not enough balance to bet");
          //   }

          // }
          // if(value == 3){
          //   $(".team_a").text(-team_a);
          //   $(".team_b").text(calrate);

          //   if(team_a > bal){
          //     $(".error").text("not enough balance to bet");
          //   }

          // }
          // if(value == 4){
          //   $(".team_b").text(-team_a);
          //   $(".team_a").text(calrate);

          //   if(team_a > bal){
          //       $(".error").text("not enough balance to bet");
          //   }
          // }

          // $(".modal").modal("hide");
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
</body>
</html>