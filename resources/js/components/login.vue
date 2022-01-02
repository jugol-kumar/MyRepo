<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h1>Login Here</h1>
                </div>
                <div class="login_body">
                    <div class="space">
                        <Input type="email"  v-model="form.email" placeholder="Email example@mail.com" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="form.password" placeholder="Enter a valid password" />
                    </div>
                </div>
                <div class="login_footer">
                    <Button type="info" @click.prevent="login">Login</Button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from "axios"
export default{
    name:'Login',
    data(){
        return{
            form:{
                email:'',
                password:''
            },
            showError: false,
        }
    },
    mounted() {
        if (this.$store.state.token) {
            this.$router.push("/");
        }else{
            this.$router.push("/login")
        }
    },
    methods:{
        login(){
            axios.post("/api/login", this.form)
            .then(res =>{
                this.$store.commit("setToken", res.data.token)
                this.$router.push("/")
            })
            .catch(err =>{
                console.log("have a error");
            })
        }
    }
}
</script>


<style scoped>
._1adminOverveiw_table_recent {
    margin: 230px auto;
}
</style>
