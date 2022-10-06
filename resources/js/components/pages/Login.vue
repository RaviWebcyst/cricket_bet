<template>
    <div class="hold-transition login-page container-fluid pt-5" >
        <div class="login-box justify-content-center row">
            <div class="login-logo "></div>
            <div class="card col-md-6">
            <div class="alert alert-danger" :class="error!=''?'':'d-none'">{{error}}</div>
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form v-on:submit.prevent="login">
                        <div class="form-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Email"
                                v-model="form.email"
                            />
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-group mb-3">
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Password"
                                v-model="form.password"
                            />
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" />
                                    <label for="remember"> Remember Me </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button
                                    type="sumbit"
                                    class="btn btn-primary btn-block btn-flat"
                                    @click="login"
                                >
                                    Sign In
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- <p class="mb-0">
                        <div class="row">
                          <div class="col-md-8">
                                <a href="javascript:;" class="text-center" @click="register"
                                    >Register a new membership</a
                                >
                          </div>
                          <div class="col-md-4">
                          <a href="javascript:;"  @click="Index">Go to Home</a>
                          </div>
                        </div>
                    </p> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            loading: false,
            error:"",
        };
    },

    methods: {
          
        // register() {
        //   localStorage.setItem("path","Register");
        //     this.$router.push({name:"Register"});

        // },
        login() {
            if(this.form.email == ""){
                alert("Email is required");
                return false;
            }
            if(this.form.password == ""){
                alert("Password is required");
                return false;
            }

            axios.post("api/login", {
                    email: this.form.email,
                    password: this.form.password,
                })
                .then((res) => {
              			console.log(res);
                    localStorage.setItem("usertoken", res.data.token);
                    this.email = "";
                    this.password = "";
                    localStorage.setItem("path","match");
                    this.$router.push({name:"match"});
                })
                .catch((err) => {
                    console.log("error");
                    this.error = "Invaild User";
                    console.log(err);
                });
        },
    },
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
/*.text1 {
    margin-left: -15px;
}
.text1 > div > div {
    background-color: transparent;
    border: none;
} */
.cstminpt::placeholder {
    color: white;
}
.p-20 {
    padding: 80px 0px !important;
}
</style>
