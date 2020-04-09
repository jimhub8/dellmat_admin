<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="1000px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Edit {{ form.name }} permissions</span>
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
                                        <v-text-field v-model="form.name" color="blue darken-2" label="Role" required></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <v-layout wrap>
                                    <v-flex sm12>
                                        <v-checkbox v-model="selectAll" label="Select All" value="all" @change="selectRoles"></v-checkbox>
                                    </v-flex>
                                    <v-flex v-for="(perm, index) in permissions" :key="index" xs6 sm3>
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
        return {
            loading: false,
            dialog: false,
            selected: [],
            selectAll: [],
            form: {},
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios
                .patch(`/roles/${this.form.id}`, {
                    form: this.form,
                    selected: this.selected
                })
                .then(response => {
                    eventBus.$emit('alertRequest', 'Updated')
                    this.loading = false;
                    this.$store.dispatch('getRoles')
                    this.close();
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
            this.dialog = false;
        },
        getRolePerm(item) {
            axios.post(`/getRolesPerm/${item.id}`, item).then((response) => {
                this.selected = response.data
            }).catch((error) => {
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                }
                this.errors = error.response.data.errors
            })
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
    },
    created() {
        eventBus.$on("openEditRoleEvent", data => {
            this.form = data
            this.dialog = true;
            this.getRolePerm(data)
        });
    },
    mounted() {
        // axios
        //     .get("/getPermissions")
        //     .then(response => {
        //         this.permissions = response.data;
        //     })
        //     .catch(errors => {
        //         this.errors = error.response.data.errors;
        //     });
    },
    computed: {
        permissions() {
            return this.$store.getters.permissions
        },

        role_perm() {
            return this.$store.getters.role_perm
        }
    },
};
</script>
