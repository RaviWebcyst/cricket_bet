<template lang="">
    

                    <div>
                      
                        <navbar />
                        <Spinner name="moon" color="#c6172c" style="text-align:center;position:relative;top:200px;" v-if="loading==true" />

                            <div class="container  col-md-6 mt-5">
                            <h6 class="mb-4 ">Balance: <small class="bal">{{balance}}</small></h6>
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
                                            <td>  ({{wallet_balance_a}})</td>
                                            <td :id="'rt_'+team_a.back" @click="rate(team_a.back,1)">{{team_a.back}}</td>
                                            <td :id="'rt_'+team_a.lay" @click="rate(team_a.lay,3)">{{team_a.lay}}</td>
                                        </tr>
                                    </tbody>
                                    
                                    <tbody>
                                        <tr>  
                                            <td>Team B : <span class="team_b"></span></td>
                                            <td>  ({{wallet_balance_b}})</td>
                                            <td :id="'rt_'+team_b.back" @click="rate(team_b.back,2)">{{team_b.back}}</td>
                                            <td :id="'rt_'+team_b.lay" @click="rate(team_b.lay,4)">{{team_b.lay}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <table class="table mt-5">
                                <thead>
                                    <tr>
                                      <!-- <th>Team</th> -->
                                      <th>Over</th>
                                      <th>Rate</th>
                                      <th>No</th>
                                      <th>Yes</th>
                                    </tr>
                                  </thead>   
                                <tbody v-if="session.length > 0">
                                  <tr v-for="(sess,i) in session">
                                    <!-- <td>{{sess.team.name}}</td> -->
                                    <td>{{sess.over}}</td>
                                    <td>{{sess.rate}}</td>
                                    <td class="table-danger" @click="sessionModal(sess.rate,i+1,'no',sess.team_id)">{{sess.no}}</td>
                                    <td class="table-success" @click="sessionModal(sess.rate,i+3,'yes',sess.team_id)">{{sess.yes}}</td>
                                  </tr>
                                </tbody>                             
                            </table>
                    </div>



<div class="modal fade" id="rate1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:50px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="text-danger error"></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" class="form-control"  id="val" name="value">
              <!-- <div class="col-md-12">
                <div class="text-danger error"></div>
              </div>  -->
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
              <div class="col-3"><button class="btn btn-light" @click="btn_val(1000)">1000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val(2000)">2000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val(5000)">5000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val(10000)">10000</button></div>
            </div>
            <div class="row mt-2">
              <div class="col-3"><button class="btn btn-light" @click="btn_val(50000)">50000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val(100000)">100000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val(200000)">200000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val(500000)">500000</button></div>
            </div>

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close1" data-dismiss="modal" @click="close" >Close</button>
          <button type="button" class="btn btn-success bet" @click="submit">Place Bet</button>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade sessModal" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:50px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="text-danger error"></div>
          <button type="button" class="close clos" data-dismiss="modal" aria-label="Close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body">
            <div class="row">
              <input type="hidden" class="form-control"  id="val1" name="value">
              <input type="hidden" class="form-control"  id="side" name="side">
              <input type="hidden" class="form-control"  id="team" name="team_id">
              <!-- <div class="col-md-12">
                <div class="text-danger error"></div>
              </div>  -->
              <div class="form-group col-md-3">
                <label> Rate</label>
                <input type="text" class="form-control"  name="rate" id="rat11">
              </div>
              <div class="form-group col-md-3">
                <label > Amount</label>
                <input type="text" class="form-control"  id="calrat11" name="amount" value="100">
              </div>
              <div class="form-group col-md-3">
                <label > Total</label>
                <input type="text" class="form-control"  id="totalAmnt1" required>
              </div>
              <div class="form-group col-md-3">
                <button type="button" class="btn btn-primary mb-2 ml-auto cal11 mt-3">Calculate</button>
                </div>
              </div>
            <div class="row">
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(100)">100</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(200)">200</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(500)">500</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(1000)">1000</button></div>
            </div>
            <div class="row mt-2">
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(5000)">5000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(10000)">10000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(20000)">20000</button></div>
              <div class="col-3"><button class="btn btn-light" @click="btn_val1(50000)">50000</button></div>
            </div>

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close1 clos1" data-dismiss="modal" @click="close" >Close</button>
          <button type="button" class="btn btn-success bet" @click="store">Place Bet</button>
        </div>
      </div>
    </div>
  </div>
    </div>
</template>
<script>
import navbar from "./nav.vue";
import $ from "jquery";

export default {
  components: {
    navbar
  },
  data() {
    return {
      balance: 0,
      credit_team_a: 0,
      debit_team_a: 0,
      credit_team_b: 0,
      debit_team_b: 0,
      team_a: [],
      team_b: [],
      wallet_balance_a:0,
      wallet_balance_b:0,
      id:"",
      session:[],
      loading:true
    }
  },
  mounted(){
    this.id = this.$route.params.id;
  },
  created() {

    axios.get("api/users", {
      headers: {
        Authorization: `Bearer ${localStorage.usertoken}`,
      },
      params:{
        token:localStorage.getItem('usertoken')
      },
    })
      .then((res) => {
        if (res.data[0] == "token_expired") {
          this.$router.push({ name: "Login" });
        }
        console.log(res);

      })
      .catch((err) => {
        console.log("error");
        console.log(err);
      });
    axios.get("api/game", {
      headers: {
        Authorization: `Bearer ${localStorage.usertoken}`,
      },
      params:{
        match_id:this.$route.params.id
      },
    }).then(res => {
      this.balance = res.data.balance;
      this.team_a = res.data.team_a;
      this.team_b = res.data.team_b;
      this.credit_team_a = res.data.wallet_credit_a;
      this.credit_team_b = res.data.wallet_credit_b;
      this.debit_team_a = res.data.wallet_debit_a;
      this.debit_team_b = res.data.wallet_debit_b;
      this.wallet_balance_a = res.data.wallet_balance_a;
      this.wallet_balance_b = res.data.wallet_balance_b;
      this.loading = false;
    }).catch(err => {
      console.log(err);
    });

    axios.get("api/session",{
      params:{
        match_id:this.$route.params.id
      }
    }).then(res=>{
        this.session = res.data;
    }).catch(err=>{
      console.log(err);
    });

  },


  methods: {
    submit(){
      var tAmnt = $("#totalAmnt").val();
      if(tAmnt == ""){
        $(".error").text("Total amount is required");
        return false;
      }
      var betAmnt = $("#calrat1").val();
      var value = $("#val").val();
      var amount = $("#calrat1").val();
        axios.post("api/betStore",{ 
            value:value,
            amount:amount,
            tAmnt:tAmnt,
            betAmnt:betAmnt,
            id:this.id,
            team_a:this.team_a.id,
            team_b:this.team_b.id,
        },
        {
          headers: {
             Authorization: `Bearer ${localStorage.usertoken}`,
          },
        }).then(res=>{
            console.log(res);
            this.balance = res.data.balance;
            this.credit_team_a = res.data.wallet_credit_a;
            this.credit_team_b = res.data.wallet_credit_b;
            this.debit_team_a = res.data.wallet_debit_a;
            this.debit_team_b = res.data.wallet_debit_b;
            this.wallet_balance_a = res.data.wallet_balance_a;
            this.wallet_balance_b = res.data.wallet_balance_b;

            $(".team_b").text("");
            $(".team_a").text("");
            $(".close1").click();
        }).catch(err=>{
          console.log(err);

            // $(".modal").removeClass("show");

        });
    },
    close(){
      $(".team_b").text("");
      $(".team_a").text("");
    },
    btn_val(value){
      $("#calrat1").val(value);
      $(".cal1").click();
    },
    btn_val1(value){
      $("#calrat11").val(value);
      $(".cal11").click();
    },
    rate(data,value){
      if(data >0){
      $(".modal").attr("id","rate_"+data);
      $("#rate_"+data).modal("show");
      var rate1 = $("#rt_"+data).text();
      $("#rat1").val(rate1);
      $("#val").val(value);

      $(".error").text("");
      $("#totalAmnt").val("");
      $(".cal1").click(function(){
          // var value = $("#val").val();
          var calrate = $("#calrat1").val();
          var rate = $("#rat1").val();
          var team_a;
          if(value == 1){
                team_a = ((rate*10)/1000) * calrate;
            }
            if(value == 3){
                team_a = calrate/(1000/(rate * 10));
            }
            if(value == 2){
                team_a = ((rate*10)/1000) * calrate;
            }
            if(value == 4){
                team_a = calrate/(1000/(rate * 10));
            } 

            $("#totalAmnt").val(team_a);
                    
            var bal = $(".bal").text();
            $(".team_a").text(team_a);
            $(".team_b").text(calrate);

          if(calrate > bal){
            $(".error").text("not enough balance to bet");
            return false;
          }
          else{
            this.error = "";
          }

        if(value == 3){
          $(".team_a").text(team_a);
          $(".team_b").text(calrate);

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
            else{
              this.error = "";
            }
        }
        if(value == 4){
          $(".team_b").text(team_a);
          $(".team_a").text(calrate);
          if(team_a > bal){
              $(".error").text("not enough balance to bet");
          }
          else{
              this.error = "";
          }
        }
      });
    }
    },
    sessionModal(data,value,side,team){
      if(data > 0){
        $(".sessModal").attr("id","sessionModal_"+data);
        $("#sessionModal_"+data).modal("show");
        $("#rat11").val(data);
        $("#side").val(side);
        $("#team").val(team);
        $(".cal11").click(function(){
          var calrate = $("#calrat11").val(); 
          var cal = 0;
          if(value == 2 || value == 1){
             cal = ((data*10)/100) * calrate;
          }
          if(value == 3 || value == 4){
            cal = calrate/(100/(data*10));
          }
          $("#totalAmnt1").val(cal);

         
        });

      }
    },
    store(){
      var amount = $("#rat11").val();
      var match_id = this.$route.params.id;
      var team_id= $("#team").val();
      var side= $("#side").val();

      axios.post("api/storeSession",{ 
            amount:amount,
            match_id:match_id,
            team_id:team_id,
            side:side
        },
        {
          headers: {
             Authorization: `Bearer ${localStorage.usertoken}`,
          },
      }).then(res=>{
        console.log(res);
        this.balance = res.data.balance;
        $(".clos").click();
      }).catch(err=>{console.log(err);});
    }
  }
}
</script>
<style >
    .modal-dialog{
      float:right;
    }
    .modal::-webkit-scrollbar{
      display:none;
    }
    @media screen and(min-width:640px){
      .modal-dialog{
        position: absolute !important;
        bottom:45px;
      }
    }
</style>