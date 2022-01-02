<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags <Button @click="addModal=true" class="float-right"><icon type="md-add" />Add Tag</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>#Id</th>
                                <th>Tag Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(tag, i) in allTags" :key="i" v-if="allTags.length">
                                <td>{{ i+1 }}</td>
                                <td class="">{{tag.tagsName}}</td>
                                <td>{{ tag.created_at|dateFormat }}</td>
                                <td>
                                    <Button v-model="editData.id" type="success" @click="showEditModal(tag)"><Icon type="md-pricetags"/></Button>
                                    <Button type="error" @click="deleteTag(tag)"><Icon type="md-trash"/></Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <Modal
                    v-model="addModal"
                    title="Add Tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input v-model="data.tagName" placeholder="Enter something..." />
                    <div slot="footer">
                        <Button type="primary" @click="addTag()"  :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Tag'}}</Button>
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
                tagName : "",
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            allTags : [],
            editData: {
                tagsName: "",
            }
        }
    },
    methods: {
        async addTag(){
            if (this.data.tagName.trim() == "") return this.e('Tag name is Required','Opps')
            const res = await this.callApi('post', 'app/create_tag', this.data)
            if (res.status === 200){
                this.allTags.unshift(res.data)
                this.s('Tag Added Successfully Done..', 'Success')
                this.addModal = false
                this.data.tagName = ""
                this.getTags()
            }else{
                if (res.status == 422){
                    if (res.data.errors.tagName){
                        this.i(res.data.errors.tagName[0], 'Opps..')
                    }
                }
                this.swr()
            }
        },
        async getTags(){
            const res = await this.callApi('get', 'app/allTag',);
            if (res.status == 200){
                this.allTags = res.data
            }else{
                this.swr();
                this.addModal = false
            }
        },
        async showEditModal(tag){
            let obj = {
              tagsName: tag.tagsName,
              id: tag.id
            }
            this.editData = obj,
            this.editModal = true
        },
        async editTag(){
            if (this.editData.tagsName.trim() == "") return this.e('Tag name is Required','Opps')
            const res = await this.callApi('post', 'app/edit-tag', this.editData)
            if (res.status === 200 ){
                this.s('Tag Updated Successfully Done..', 'Success')
                this.editModal = false
                this.getTags()
            }
        },
        async deleteTag(tag){
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
                    const res = await this.callApi('post', 'app/delete-tag', tag)
                    if (res.status === 200){
                        this.s('Tag Delete Successfully Done..', 'Success')
                        this.getTags()
                    }else{
                        this.swr()
                    }
                }
            })
        }
    },
    mounted(){
        this.getTags()
    },
}
</script>
