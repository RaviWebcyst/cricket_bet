<template lang="">
<div>
    <div>
        <navbar />
        <Spinner name="moon" color="#c6172c" style="text-align:center;position:relative;top:200px;" v-if="loading==true" />
        <div class="container  col-md-6 mt-5">
                <table class="table mt-1">
                    <thead>
                        <tr>
                            <td>Match ID</td>
                            <td>Match Name</td>
                            <td>Team A Name</td>
                            <td>Team B Name</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody v-if="matchs.length > 0">
                        <tr v-for="(match,i) in matchs">
                            <td>{{match.id}}</td>
                            <td>{{match.name}}</td>
                            <td>{{match.team_a_name}}</td>
                            <td>{{match.team_b_name}}</td>
                            <td><a href="javascript:;" class="btn btn-sm btn-success" @click="home(match.id)">Play</a></td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>

</div>
</template>

<script>
import navbar from "./nav.vue";
export default {
    components:{
        navbar
    },
    data(){
        return{
            matchs:[],
            loading:true
        }
    },
    created(){
        axios.get("api/matchs").then(res=>{
            this.loading = false;
            this.matchs = res.data.matchs;
            
        }).catch(err=>{
            this.loading = false;
            console.log(err);
        });
    },
    methods:{
        home(id){
            localStorage.setItem("path","Home");
            this.$router.push({name:"Home",params:{id:id}});
        }
    }
}
</script>

<style lang="">

</style>
