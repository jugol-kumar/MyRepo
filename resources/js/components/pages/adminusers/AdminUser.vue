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
                                <th>Email</th>
                                <th>User Role</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(admin, i) in allUser" :key="i" v-if="allUser.length">
                                <td>{{ i+1 }}</td>
                                <td class="">{{admin.fullname}}</td>
                                <td>{{ admin.email }}</td>
                                <td>
                                     <span class="badge badge-success">{{ admin.userType }}</span>
                                </td>
                                <td>{{ admin.created_at|dateFormat }}</td>
                                <td>
                                    <Button v-model="editData.id" type="success" @click="showEditModal(admin)"><Icon type="md-pricetags"/></Button>
                                    <Button type="error" @click="deleteTag(admin)"><Icon type="md-trash"/></Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <Modal
                    v-model="addModal"
                    title="Add User"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space">
                        <Input type="text" v-model="data.userName" placeholder="Enter full name..." />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="E.x admin@mail.com" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Password" />
                    </div>
                    <div class="space">
                        <Select v-model="data.userType" placeholder="Select User Type">
                            <Option disabled="true" selected value="">~~Select User Type~~</Option>
                            <Option value="admin">Admin</Option>
                            <Option value="editor">Editor</Option>
                            <Option value="publisher">Publisher</Option>
                        </Select>
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
                    <Input v-model="editData.tagsName" placeholder="Enter something..." />
                    <div slot="footer">
                        <Button type="primary" @click="editTag()"  :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Edit Tag'}}</Button>
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
                userName : "",
                email:"",
                password:'',
                userType:''
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            allUser : [],
            editData: {
                tagsName: "",
            }
        }
    },
    methods: {
        async addUser(){
            // if (this.data.userName.trim() == "") return this.e('User name is Required','Opps')
            // if (this.data.email.trim() == "") return this.e('Email is Required','Opps')
            // if (this.data.password.trim() == "") return this.e('Password is Required','Opps')
            // if (this.data.userType.trim() == "") return this.e('User Type is Required','Opps')

            const res = await this.callApi('post', 'app/create-user', this.data)
            if (res.status === 200){
                console.log(res.data);
                this.allUser.unshift(res.data)
                this.s('Tag Added Successfully Done..', 'Success')
                this.addModal = false
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
        async allUsers(){
            const res = await this.callApi('get', 'app/all-user',);
            if (res.status == 200){
                this.allUser = res.data
            }else{
                this.swr();
                this.addModal = false
            }
        },
        // async showEditModal(tag){
        //     let obj = {
        //         tagsName: tag.tagsName,
        //         id: tag.id
        //     }
        //     this.editData = obj,
        //         this.editModal = true
        // },
        // async editTag(){
        //     if (this.editData.tagsName.trim() == "") return this.e('Tag name is Required','Opps')
        //     const res = await this.callApi('post', 'app/edit-tag', this.editData)
        //     if (res.status === 200 ){
        //         this.s('Tag Updated Successfully Done..', 'Success')
        //         this.editModal = false
        //         this.allUsers()
        //     }
        // },
        // async deleteTag(tag){
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#52b6ff',
        //         cancelButtonColor: '#e85c5c',
        //         confirmButtonText: "Delete"
        //     }).then(async (result) => {
        //         if (result.isConfirmed) {
        //             const res = await this.callApi('post', 'app/delete-tag', tag)
        //             if (res.status === 200){
        //                 this.s('Tag Delete Successfully Done..', 'Success')
        //                 this.allUsers()
        //             }else{
        //                 this.swr()
        //             }
        //         }
        //     })
        // }
    },
    mounted(){
        this.allUsers()
    },
}
</script>
