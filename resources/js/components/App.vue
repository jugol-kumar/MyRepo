<template>
    <div>
        <!--========== ADMIN SIDE MENU one ========-->
        <div class="_1side_menu" v-if="this.$store.state.showView">
            <div class="_1side_menu_logo">
                <h3 style="text-align:center;">Logo Image</h3>
                <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
            </div>

            <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
            <div class="_1side_menu_content">
                <div class="_1side_menu_img_name">
                    <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                    <p class="_1side_menu_name">Admin</p>
                </div>

                <!--~~~ MENU LIST ~~~~~~-->
                <div class="_1side_menu_list">
                    <ul class="_1side_menu_list_ul">
                        <li><router-link to="/"><Icon type="md-person" />Airlines</router-link></li>
                        <li><a @click="logout"><Icon type="md-power" />Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--========== ADMIN SIDE MENU ========-->

        <!--========= HEADER ==========-->
        <div class="header" v-if="this.$store.state.showView">
            <div class="_2menu _box_shadow">
                <div class="_2menu_logo">
                    <ul class="open_button">
                        <li>
                            <Icon type="ios-list" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--========= HEADER ==========-->
        <router-view/>
    </div>
</template>


<script>
import Header from "./persial/Header";
import SideBar from "./persial/SideBar";
import Footer from "./persial/Footer";
export default {
    components:{
      Header,
      SideBar,
      Footer,
    },
    show: false,
    name: "App",
    created() {
        if (this.$store.state.token) {
            this.$store.commit("showSideTop", true);
            this.$router.push("/");
        }else{
            this.show=false;
            this.$store.commit("showSideTop", false);
            this.$router.push("/login")
        }
    },
    methods: {
        logout(){
            axios.post("api/logout", {token: this.$store.state.token})
            .then(res =>{
                this.$store.commit("clearToken");
                this.$store.commit("showSideTop", false);
                this.$router.push("/login")
            })
            .catch(err=>{
                this.$store.commit("clearToken");
                this.$store.commit("showSideTop", false);
                this.$router.push("/login")
            })
        }
    }
}
</script>

<style scoped>

</style>
