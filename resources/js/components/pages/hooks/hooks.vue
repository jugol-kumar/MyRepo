<template>
    <div>
        <h1 ref="myref">This Is From Hooks </h1>
        <p class=""> my name is : {{name}}</p>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name:'jugol kumar'
        }
    },
    beforeCreate() {
        console.log(this.name)
    },
    created() {
        console.log('hello this is from created functoin', this.name)
    },
    mounted() {
        console.log(this.$refs.myref)
    }
}
</script>

<style scoped>

</style>
