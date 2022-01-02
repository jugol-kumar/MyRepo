<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1>Hey Im main component. Im Use THis All Other Component. </h1>
                <h2>This is form vuex stats {{counter}}</h2>
                <comA></comA>
                <comB></comB>
                <comC></comC>

                <Button type="info" @click="changeCounter()">Change the stat value</Button>
            </div>
        </div>
    </div>
</template>

<script>
import comA from "./comA";
import comB from "./comB";
import comC from "./comC";
import {mapGetters} from 'vuex'
export default {
    data(){
      return {
          sowMe: 'Oh yeah Im watching'
      }
    },
    components: {
        comA,
        comB,
        comC
    },
    methods: {
        changeCounter(){
            this.$store.dispatch('cheangeCounterAction', 1)
            // this.$store.commit('changeCorrentValue', 1);
        },
        watchRuning(){
            console.log('im runing when watch me. ')
        }
    },
    computed: {
        ...mapGetters({
            'counter' : 'getCounter'
        })
    },
    watch: {
        counter(value){
            console.log('this count number is:', value)
            this.watchRuning();
            alert(this.sowMe)
        }
    }

}
</script>

<style scoped>

</style>
