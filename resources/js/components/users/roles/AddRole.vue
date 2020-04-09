<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="1000px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Role</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm12>
                                        <el-select v-model="form.guard_name" clearable placeholder="Client Type" style="width: 100%;" @change="getPermissions">
                                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                        <v-flex xs12 sm12>
                                            <v-text-field v-model="form.name" color="blue darken-2" label="Role" required></v-text-field>
                                            <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                                        </v-flex>
                                        <v-checkbox v-model="selectAll" label="Select All" value="all" @change="selectRoles"></v-checkbox>
                                        <!-- <v-checkbox v-model="selectAll" label="Unselect All" value="all" @change="unselectRoles" v-else></v-checkbox> -->
                                </v-layout>
                                <v-layout wrap>
                                    <v-flex v-for="(perm, index) in sortPerm" :key="index" xs6 sm3>
                                        <v-checkbox v-model="selected" :label="perm.name" :value="perm.name"></v-checkbox>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn text @click="resetForm">reset</v-btn>
                                <v-btn text @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" text color="primary" @click="save" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        const defaultForm = Object.freeze({
            name: "",
            description: ""
        });
        return {
            errors: [],
            selectAll: [],
            dialog: false,
            loading: false,
            selected: [],
            defaultForm,
            loader: false,
            permissions: [],
            form: Object.assign({}, defaultForm),
            options: [{
                value: 'web',
                label: 'User'
            }, {
                value: 'clients',
                label: 'Client'
            }],
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios
                .post("/roles", {
                    form: this.$data.form,
                    selected: this.$data.selected
                })
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    this.$store.dispatch('getRoles')
                    this.$store.dispatch('alertEvent', 'Role created')
                    this.close()
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
            this.$refs.form.reset();
        },
        close() {
            this.dialog = false
        },
        selectRoles() {
            this.selected = [];
            // console.log(sel)
            this.selectAll.forEach(sel => {
                this.permissions.forEach(perm => {
                    this.selected.push(perm.name);
                });
            });
        },
         getPermissions() {
            this.selected = [];
             axios
            .get(`/getPermissions/${this.form.guard_name}`)
            .then(response => {
                this.permissions = response.data;
            })
            .catch(errors => {
                this.errors = error.response.data.errors;
            });
         }
    },
    computed: {
        formIsValid() {
            return this.form.name;
        },

        sortPerm() {
            return _.orderBy(this.permissions, 'name', 'asc')
        }
    },
    mounted() {

    },
    created() {
        eventBus.$on('openCreateRoleEvent', data => {
            this.dialog = true
        });
    },
};
</script>
