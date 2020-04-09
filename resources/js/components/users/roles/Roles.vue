<template>
<div>
    <v-content>
        <v-container fluid fill-height>
            <v-layout justify-center align-center>
                <div v-show="loader" style="text-align: center; width: 100%;">
                    <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
                </div>
                <v-card v-show="!loader" style="width: 100%;">
                    <v-card-title>
                        Roles
                        <v-btn @click="openAdd" text color="primary">Add Roles</v-btn>
                        <!-- <v-spacer></v-spacer> -->
                        <v-tooltip right>
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getRoles">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                            </template>
                            <span>Refresh</span>
                        </v-tooltip>
                    </v-card-title>
                    <v-flex sm12>

                        <vue-good-table class="table-hover" :columns="columns" :rows="roles" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" v-loading="loading">
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
                                    <v-tooltip bottom v-if="user.can['delete roles']">
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" class="mx-0" @click="deleteItem(props.item)" slot="activator">
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
                </v-card>
            </v-layout>
        </v-container>
    </v-content>
    <AddRole></AddRole>
    <!--  <ShowRole @closeRequest="close" :openShowRequest="dispShow"></ShowRole> -->
    <EditRole></EditRole>
</div>
</template>

<script>
import AddRole from './AddRole.vue'
// // import ShowRole from './ShowRole.vue'
import EditRole from './EditRole.vue'
export default {
    props: ['user'],
    components: {
        AddRole,
        // ShowRole,
        EditRole
    },
    data() {
        return {
            loader: false,
            columns: [{
                    label: 'Id#',
                    field: 'id',
                    type: 'number',
                },
                {
                    label: 'Role',
                    field: 'name',
                },
                {
                    label: 'Description',
                    field: 'description',
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
            search: '',
        }
    },
    methods: {
        openShow(key) {

        },
        openAdd() {
            eventBus.$emit('openCreateRoleEvent')
        },
        openEdit(item) {
            eventBus.$emit('openEditRoleEvent', item)

            var payload = {
                model: 'permissions',
                update_list: 'updatePermissionList',
            }

            this.$store.dispatch('getItems', payload)
        },

        deleteItem(item) {
            this.$confirm('Are you sure you want to delete. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
                center: true
            }).then(() => {
                var payload = {
                    model: 'roles',
                    id: item.id,
                }
                this.$store.dispatch('deleteItem', payload)
                    .then(() => {
                        this.getRoles()
                        this.$message({
                            type: 'success',
                            message: 'Role Deleted'
                        });
                    })
            }).catch(() => {
                this.$message({
                    type: 'error',
                    message: 'Delete canceled'
                });
            });

        },

        getRoles() {
            var payload = {
                model: 'roles',
                update_list: 'updateRoleList',
            }

            this.$store.dispatch('getItems', payload)
                .then(() => {
                    this.loader = false
                })
        },
    },
    mounted() {
        // this.loader = true
        this.getRoles()
    },
    computed: {
        roles() {
            return this.$store.getters.roles;
        },
        loading() {
            return this.$store.getters.loading;
        },
    },
    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view roles"]) {
    //         next();
    //       } else {
    //         next("/");
    //       }
    //     });
    //   }
}
</script>
