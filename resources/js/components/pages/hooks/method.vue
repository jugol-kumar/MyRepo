<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">this is from methods</h1>
                <h1 class="card-text">This Number Is : {{ views }}</h1>
                <button class="btn btn-success" @click="upfunction(1)">Increase</button>
                <button class="btn btn-primary" @click="upfunction(-1)">Decrease</button>
            </div>
        </div>

        <br><br>
        <br><br>
        <br><br>
        <br><br>

        <div class="card">
            <div class="card-body" v-for="(blog, i) in blogs" :key="i">
                <h1 class="card-title">id: #{{i+1}}</h1>
                <h1 class="card-title">{{ blog.title }}</h1>
                <p class="card-text">{{ blog.post }}</p>
            </div>
        </div>


        <br><br>
        <br><br>
        <div class="card">
            <h1 v-if="showStatus">This Content For True</h1>
            <h1 v-else>This Content For False</h1>

            <button class="btn btn-warning" @click="showStatus = !showStatus">Change</button>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            views : "",
            blogs :[],
            showStatus: false,
        }
    },

    methods:{
        upfunction(data){
            this.views += data
        }
    },

    created() {
        this.views = 100
        let post = [
            {title: 'This is Post Title',  'post' : 'this is blog post', id:1},
            {title: 'This is Post Title',  'post' : 'this is blog post', id:2},
            {title: 'This is Post Title',  'post' : 'this is blog post', id:3},
            {title: 'This is Post Title',  'post' : 'this is blog post', id:4},
            {title: 'This is Post Title',  'post' : 'this is blog post', id:5},
        ]
        this.blogs = post
    }
}
</script>

<style scoped>

</style>
