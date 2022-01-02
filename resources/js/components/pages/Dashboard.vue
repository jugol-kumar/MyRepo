<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Users <Button @click="addModal=true" class="float-right"><icon type="md-add" />Add user</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>#Id</th>
                                <th>User Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(admin, i) in allUser" :key="i" v-if="allUser.length">
                                <td>{{ i+1 }}</td>
                                <td class="">{{admin.name}}</td>
                                <td>{{ admin.description }}</td>
                                <td>{{ admin.created_at|dateFormat }}</td>
                                <td>
                                    <Button v-model="editData.id" type="success" size="small" @click="showEditModal(admin)"><Icon type="md-pricetags"/></Button>
                                    <Button type="error" @click="deleteTag(admin)" size="small"><Icon type="md-trash"/></Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                        <div class="space">

                            <Page :total="paginateInfo.total" :current="paginateInfo.current_page" @on-change="allUsers" :page-size="parseInt(paginateInfo.per_page)"/>
                        </div>
                    </div>
                </div>

                <Modal
                    v-model="addModal"
                    title="Add User"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space">
                        <Input type="text" v-model="data.name" placeholder="Enter full name..." />
                    </div>
                    <div class="space">
                        <Input v-model="data.details" type="textarea" :rows="10" placeholder="Enter something..." />
                    </div>
                    <div slot="footer">
                        <Button type="primary" @click="addUser()"  :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add User'}}</Button>
                        <Button type="default" @click="addModal=false">close</Button>
                    </div>
                </Modal>

                <Modal
                    v-model="editModal"
                    title="Edit Tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space">
                        <Input type="text" v-model="editData.name" placeholder="Enter full name..." />
                    </div>
                    <div class="space">
                        <Input v-model="editData.description" type="textarea" :rows="10" placeholder="Enter something..." />
                    </div>
                    <div slot="footer">
                        <Button type="primary" @click="editTag()"  :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Edit User'}}</Button>
                        <Button type="default" @click="editModal=false">close</Button>
                    </div>
                </Modal>

            </div>
        </div>
    </div>
</template>

<script>

export default {
    data () {
        return {
            data: {
                name : "",
                details:"",
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            allUser : [],
            paginateInfo:null,
            total:5,
            editData: {
                name: "",
                description:"",
                id:"",
            }
        }
    },
    methods: {
        async addUser(){
            if (this.data.name.trim() == "") return this.e('User name is Required','Opps')
            const res = await this.callApi('post', 'api/add-user', this.data)
            if (res.status === 200){
                console.log(res.data);
                this.allUser.unshift(res.data)
                this.s('Tag Added Successfully Done..', 'Success')
                this.addModal = false
                this.data.name =""
                this.data.details=""
                this.allUsers()
            }else{
                if (res.status == 422){
                    console.log(res.data);
                    for (let i=0; i< res.data.errors.length; i++){
                        console.log(res.data.errors[i])
                        // this.i(res.data.errors[i][0], 'Opps');
                    }
                    // if (res.data.errors.tagName){
                    //     this.i(res.data.errors.tagName[0], 'Opps..')
                    // }
                }
                this.swr()
            }
        },
        async allUsers(page=1){
            const res = await this.callApi('get', `api/all-user?page=${page}&total=${this.total}`,);
            if (res.status == 200){
                this.allUser = res.data.data.data
                this.paginateInfo = res.data
            }else{
                this.swr();
                this.addModal = false
            }
        },

        async showEditModal(user){
            this.editData.name = user.name;
            this.editData.description = user.description;
            this.editData.id = user.id
                this.editModal = true
        },

        async editTag(){
            const res = await this.callApi('post', 'api/edit-user', this.editData)
            if (res.status === 200 ){
                this.s('Tag Updated Successfully Done..', 'Success')
                this.editModal = false
                this.allUsers()
            }
        },

        async deleteTag(user){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#52b6ff',
                cancelButtonColor: '#e85c5c',
                confirmButtonText: "Delete"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await this.callApi('post', 'api/delete-user', user)
                    if (res.status === 200){
                        this.s('Tag Delete Successfully Done..', 'Success')
                        this.allUsers()
                    }else{
                        this.swr()
                    }
                }
            })
        },

        // async getPageData(page=1){
        //     const res = await this.callApi("get", "api/pageData")
        //     .then(res =>{
        //
        //     })
        //     .catch(err=>{
        //
        //     })
        // },

    },
    mounted() {
        this.allUsers()
        if (this.$store.state.token) {
            this.$store.commit("showSideTop", true);
            this.$router.push("/");
        }else{
            this.$store.commit("showSideTop", false);
            this.$router.push("/login")
        }
    }
}
</script>
