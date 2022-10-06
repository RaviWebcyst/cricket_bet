<template>
    <div class="hold-transition register-page container-fluid pt-5" >
    <div class="register-box justify-content-center row">
  
    <div class="card col-md-6">
    <div class="alert alert-danger" v-if="errors.length > 0">{{errors}}</div>
  
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register User</p>
  
        <form>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Sponser Id" v-model="form.spid" @change="getSpid()">
            <!-- <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div> -->
          </div>
            <div class="text-danger ">{{error}}</div>
            <div class="text-success ">{{success}}</div>
  
          <div class="form-group mb-3 mt-3">
            <input type="text" class="form-control" placeholder="Full name" v-model="form.name">
            <!-- <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div> -->
          </div>
          <div class="form-group mb-3">
            <input type="email" class="form-control" placeholder="Email" v-model="form.email">
            <!-- <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div> -->
          </div>
          <div class="form-group mb-3">
            <input type="text" class="form-control" placeholder="Phone" v-model="form.phone">
            <!-- <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div> -->
          </div>
          <div class="form-group mb-3">
            <input type="password" class="form-control" placeholder="Password" v-model="form.password">
            <!-- <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div> -->
          </div>
  
          <div class="row">
            <div class="col-6">
              <button type="button" class="btn btn-primary btn-block btn-flat" @click="register()" :disabled="form.disable">Register</button>
            </div>
            <div class="col-6">
              <!-- <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                 I agree to the <a href="#">terms</a>
                </label>
              </div> -->
            </div>
          </div>
        </form>
          <div class="row">
            <div class="col-md-8">
                <a href="javascript:;" @click="login()" class="text-center">I already have a membership</a>
            </div>
            <!-- <div class="col-md-4">
                <a href="javascript:;" @click="Index()" >Go to Home</a>
            </div> -->
          </div>
  
      </div>
    </div>
  </div>
    </div>
  </template>
  
  <script>
  export default {
      data() {
          return {
              loading: false,
              form: {
                  email: "",
                  password: "",
                 name:"",
                 phone:"",
                 spid:"",
              disable:false
              },
              error:"",
              success:"",
              errors:[]
          };
      },
      mounted(){
      if (this.$route.params.id) {
             this.form.spid = this.$route.params.id;
         }
      },
  
      methods: {
        
        login(){
          localStorage.setItem("path","Login");
          this.$router.push({name:"Login"});
        },
          register() {
              // this.loading = true;
              // if (this.form.email == "") {
              //     alert("Phone is required");
              // }
              // if (this.form.password == "") {
              //     alert("Password is required");
              // }
              axios
                  .post("api/register", {
                      email: this.form.email,
                      password: this.form.password,
                      name: this.form.name,
                  })
                  .then(res => {
                  })
                  .catch(err => {
                  console.log(err);
                      if (err.response.data.res) {
                          alert(err.response.data.res);
                      } else {
                          alert("error while register");
                      }
                  });
          }
      }
  };
  </script>
  
  <style scoped>
  .cstminpt {
      border: 1px solid goldenrod;
      background: goldenrod;
      color: white;
      height: 40px;
      margin: 20px 0px;
  }
  .cstminpt::placeholder {
      color: white;
  }
  .p-20 {
      padding: 60px 0px !important;
  }
  /* .cstminpt {
      border: none;
  }
  .text {
      margin-left: 13px;
  }
  .text1 {
      margin-left: -15px;
  }
  .text > div > div {
      background-color: transparent;
      border: none;
  }
  .text1 > div > div {
      background-color: transparent;
      border: none;
  } */
  </style>
  