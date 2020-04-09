<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div style="width: 100%;">
                    <!-- users display -->
                    <v-card-title>
                        Users
                        <!-- <download-excel :data="users" :fields="json_fields">
                            Export
                            <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                        </download-excel> -->
                        <v-btn slot="activator" color="primary" dark text @click="openAdd">Add User</v-btn>
                        <v-btn slot="activator" color="orange" dark text @click="openDeleted">Deleted Users</v-btn>
                        <v-tooltip right>
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getUsers">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                            </template>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                    </v-card-title>
                    <v-flex sm12 v-loading="loading_t">
                        <vue-good-table class="table-hover" :columns="columns" :rows="users.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" >
                            <template slot="table-row" slot-scope="props">
                                <span v-if="props.column.field == 'created_at'">
                                    <span>
                                        <el-tag type="success">{{props.row.created_at}}</el-tag>
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'actions'">
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" class="mx-0" @click="openEdit(props.row)" slot="activator">
                                                <v-icon small color="blue darken-2">edit</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Edit</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" class="mx-0" @click="openShow(props.row)" slot="activator">
                                                <v-icon small color="blue darken-2">visibility</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>View user</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" class="mx-0" @click="openPerm(props.row)" slot="activator">
                                                <v-icon small color="orange darken-2">dialpad</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Edit Permissions</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" class="mx-0" @click="deleteItem(props.row)" slot="activator">
                                                <v-icon small color="pink darken-2">delete</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Delete</span>
                                    </v-tooltip>
                                </span>
                                <span v-else>
                                    {{props.formattedRow[props.column.field]}}
                                </span>
                            </template>
                        </vue-good-table>
                    </v-flex>
                    <!-- users display -->
                </div>
            </v-layout>
        </v-container>
        <!-- <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="green" style="margin: 1rem"></v-progress-circular>
        </div> -->
        <v-sheet :color="`grey ${theme.isDark ? 'darken-2' : 'lighten-4'}`" class="px-3 pt-3 pb-3" v-show="loader">
            <v-skeleton-loader class="mx-auto" max-width="900" type="table"></v-skeleton-loader>
        </v-sheet>
    </v-content>
    <Create></Create>
    <Edit></Edit>
    <PermUser></PermUser>
    <UserProfile></UserProfile>
    <DeletedUsers></DeletedUsers>
</div>
</template>

<script>
import Create from "./Create.vue";
import PermUser from './Permission.vue';
import DeletedUsers from './DeletedUsers.vue';
import Edit from "./Edit.vue";
import UserProfile from './UserProfile'
export default {
    inject: ['theme'],
    props: ["user"],
    name: 'users',
    components: {
        Create,
        PermUser,
        Edit,
        UserProfile,
        DeletedUsers
    },
    data() {
        return {
            loading_t: false,

            columns: [{
                    label: 'Id#',
                    field: 'id',
                    type: 'number',
                },
                {
                    label: 'User name',
                    field: 'name',
                },
                {
                    label: 'User Email',
                    field: 'email',
                },
                {
                    label: 'Phone Number',
                    field: 'phone',
                },
                {
                    label: 'Address',
                    field: 'address',
                },
                {
                    label: 'Created On',
                    field: 'created_at',
                    // type: 'date',
                    // dateInputFormat: 'YYYY-MM-DD',
                    // dateOutputFormat: 'MMM Do YYYY',
                },
                {
                    label: 'Actions',
                    field: 'actions',
                },
            ],
            loader: false,
        };
    },
    methods: {
        openDeleted() {
            eventBus.$emit('openDeletedEvent')
        },
        openAdd() {
            if (!this.roles) {
                this.getRoles()
            }
            eventBus.$emit('openCreateUserEvent')
        },
        openEdit(item) {
            if (!this.roles) {
                this.getRoles()
            }
            eventBus.$emit('openEditUserEvent', item)
        },
        openPerm(item) {
            eventBus.$emit('permEvent', item)
            var payload = {
                model: 'filterusers',
                update: 'updateUsersList',
            }
            this.$store.dispatch('getItems', payload)
        },

        openShow(item) {

        },

        deleteItem(item) {
            this.$confirm('This will permanently delete ' + item.name +'. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true
            }).then(() => {
                this.delete_user(item)
            }).catch(() => {
                this.$message({
                    type: 'error',
                    message: 'Delete canceled'
                });
            });
        },
        delete_user(item) {
            this.$store.dispatch("deleteItem", "users/" + item.id).then(response => {
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
                this.getUsers();
            });
        },
        getUsers() {
            var payload = {
                model: 'users',
                update_list: 'updateUsersList',
            }

            this.$store.dispatch('getItems', payload)
                .then((response) => {
                    this.loader = false
                })
        },

        getRoles() {
             var payload = {
                model: 'roles',
                update: 'updateRoleList',
            }

            this.$store.dispatch('getItems', payload)
        },
    },
    computed: {
        users() {
            return this.$store.getters.users
        },
        loading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        // this.loader = true;
        this.getUsers();
    },
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         if (vm.user.can["view users"]) {
    //             next();
    //         } else {
    //             next("/");
    //         }
    //     });
    // },

    created() {
        eventBus.$on('getUsersEvent', data => {
            this.getUsers()
        })
    },
};
</script>

<style scoped>
.content--wrap {
    margin-top: -100px;
}

#profile {
    width: 70px;
    height: 60px;
    border-radius: 50%;
    margin-left: 80px;
    margin-top: -30px;
}

i {
    padding: 7px;
    background: #f0f0f0;
    border-radius: 50%;
}

.list-group-item:hover,
.list-group-item:focus {
    z-index: 1;
    background: #f9f9f9;
    text-decoration: none;
}
</style>
