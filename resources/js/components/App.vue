<template>
    <v-app id="inspire">
        <v-app-bar
            v-if="this.$store.state.showView"
            app
            color="white"
            elevation="4"
        >
            <v-toolbar-title>Airlines App</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            app
            v-if="this.$store.state.showView"
        >
            <v-sheet
                color="grey lighten-4"
                class="pa-4"
            >
                <v-avatar
                    class="mb-4"
                    color="grey darken-1"
                    size="64"
                ></v-avatar>

                <div>john@vuetifyjs.com</div>
            </v-sheet>

            <v-divider></v-divider>

            <v-list>
                <v-list-item link>
                    <v-list-item-icon>
                        <v-icon>mdi-inbox-arrow-down</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Airlines</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="logout">
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <router-view></router-view>


    </v-app>
</template>
<script>
export default {
    data: () => ({
        cards: ['Today', 'Yesterday'],
        drawer: true,
        search: '',
        actionLogin: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {
                text: 'id',
                align: 'left',
                sortable: false,
                value: 'id',
            },
            { text: 'Name', value: 'name' },
            { text: 'Description', value: 'description'},
            { text: 'Actions', value: 'actions', sortable: false },
        ],
        desserts: [],
        editedIndex: -1,
        editedItem: {
            name: '',
            description: "",
        },

        defaultItem: {
            name: '',
            calories: 0,
            fat: 0,
            carbs: 0,
            protein: 0,
        },
    }),
    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    created () {
        this.initialize();
        if (this.$store.state.token) {
            this.$store.commit("showSideTop", true);
            this.$router.push("/");
        }else{
            this.$store.commit("showSideTop", false);
            this.$router.push("/login")
        }
    },
    methods: {
        async initialize() {
            const res = await this.callApi('get', `api/all-user`,);
            if (res.status == 200) {
                this.desserts = res.data.data
                console.log(res.data.data);
            } else {
                this.swr();
                this.addModal = false
            }
        },

        editItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            const res = await this.callApi('post', 'api/delete-user', this.editedItem)
            if (res.status === 200) {
                this.s('Data Deleted Successfully Done..', 'Success')
                this.editModal = false
                this.closeDelete ();
                this.initialize();
            } else {
                this.swr("Have an error! try again later", "Error")
            }
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async save() {
            if (this.editedIndex > -1) {
                const res = await this.callApi('post', 'api/edit-user', this.editedItem)
                if (res.status === 200) {
                    this.s('Data Updated Successfully Done..', 'Success')
                    this.editModal = false
                    this.close();
                    this.initialize()
                }else{
                    this.e(res.data.errors.name[0], "Error")
                }
            } else {
                const res = await this.callApi('post', 'api/add-user', this.editedItem)
                if (res.status === 200) {
                    this.s('Data Save Successfully Done', 'Success')
                    this.editModal = false
                    this.close();
                    this.initialize()
                }else{
                    this.e(res.data.errors.name[0], "Error")
                }
            }
            this.close()
        },
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
    },
}
</script>
