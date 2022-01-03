<template>
    <v-main>
        <v-container
            class="py-8 px-6"
            fluid>
            <v-layout column align-center>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                        ></v-text-field>
                        <v-data-table
                            :headers="headers"
                            :items="desserts"
                            sort-by="calories"
                            class="elevation-1"
                            :search="search"
                        >



                            <template v-slot:top>
                                <v-toolbar
                                    flat
                                >
                                    <v-dialog
                                        v-model="dialog"
                                        max-width="550px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                color="primary"
                                                dark
                                                class="mb-2"
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                New Item
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="text-h5">{{ formTitle }}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="12"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.name"
                                                                label="Airlines name"
                                                                hide-details="auto"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="12"
                                                        >
                                                        </v-col>
                                                        <v-textarea
                                                            name="input-7-1"
                                                            filled
                                                            label="Airlines description"
                                                            auto-grow
                                                            v-model="editedItem.description"
                                                        ></v-textarea>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="close"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="save"
                                                >
                                                    Save
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                        <v-card>
                                            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                                <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editItem(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteItem(item)"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>

                            <template v-slot:no-data>
                                <v-btn
                                    color="primary"
                                    @click="initialize"
                                >
                                    Reset
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-layout>
        </v-container>
    </v-main>
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
        }
    },
}
</script>
