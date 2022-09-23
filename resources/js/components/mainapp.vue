<template>
    <div >
        
        <router-view />
    </div>
</template>

<script>
import $ from 'jquery';
import navbar from "./pages/nav.vue";
export default {

    components:{
        navbar
    },
    methods: {
        login() {
            // localstorage.setItem("path","Login");
            this.$router.push({name:"Login"});
        }
    },
    created(){
    axios
        .get("/api/users", {
            headers: {
                Authorization: `Bearer ${localStorage.usertoken}`,
            },
            // params:{
            //   token:localStorage.getItem('usertoken')
            // },
        })
        .then((res) => {
            if (res.data[0] == "token_expired") {
                // localStorage.setItem("path","Login");
                this.$router.push({name:"Login"});
            }

        })
        .catch((err) => {
          console.log("error");
            console.log(err);
        });

        // if(localStorage.getItem('usertoken') != null) {
        //       localStorage.setItem("path","Home");
        //       //var path = localStorage.getItem('path');
        //       this.$router.push({name:"Home"});
        //   } else {
        //     //   localStorage.setItem("path","Login");
        //       this.$router.push({name:"Login"});
        //   }
    },
    mounted() {
          if(this.$route.name == "invite") {
            // localStorage.setItem("path","invite");
            this.$router.push({ name: "invite" });
           }
        else {
          if(localStorage.getItem('usertoken') != null) {
              localStorage.setItem("path","match");
              //var path = localStorage.getItem('path');
              this.$router.push({name:"match"});
          } else {
              localStorage.setItem("path","Login");
              this.$router.push({name:"Login"});
          }
        }

    }




};
</script>
