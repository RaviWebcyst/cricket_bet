<template >
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="javascript:;">
                    Cricket Bet
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                       

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <!-- <li class="nav-item" v-if="auth==false">
                                <a class="nav-link" href="javascript:;" @click="login()">Login</a>
                        </li>
                        <li class="nav-item" v-if="auth==false">
                                <a class="nav-link" href="javascript:;" @click="register()">Register</a>
                        </li> -->
                        <li class="nav-item dropdown" v-if="auth==true">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                {{name}}<span class="caret"></span>
                                </a>
                                
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="javascript:;"
                                    @click="logout">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
export default {
    data(){
        return{
            name:"",
            auth:false,
        }

    },
    created(){
        if(localStorage.getItem('usertoken') !=null){
            this.auth = true;
        }
        else{
            this.auth = false;
        }

        axios.get("api/users", {
                headers: {
                    Authorization: `Bearer ${localStorage.usertoken}`,
                },
                // params:{
                //   token:localStorage.getItem('usertoken')
                // },
            })
            .then((res) => {
                this.name = res.data.user.name;
                if (res.data[0] == "token_expired") {
                    this.$router.push({name:"Login"});
                }
                // console.log(res.data.user.name);

            })
            .catch((err) => {
          		console.log("error");
                console.log(err);
            });
            
      

        
    },
    methods:{
        login(){
            this.$router.push({name:"Login"});
        },
        register(){
            this.$router.push({name:"Register"});
        },
        logout(){
            localStorage.removeItem('usertoken');
            this.$router.push({name:"Login"});
        }
       
    }
}
</script>
<style >
    
</style>