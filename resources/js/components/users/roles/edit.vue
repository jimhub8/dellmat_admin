<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Edit Role</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                           <v-card-text>
                                <div>
                                    <label for="">Role</label>
                                    <el-input placeholder="Admin" v-model="form.name"></el-input>
                                </div>

                                <v-layout wrap>
                                    <v-flex v-for="(permission, index) in permissions" :key="index" xs6 sm4>
                                        <v-checkbox v-model="form.permissions" :label="permission.name" :value="permission.id" @change="select_permission"></v-checkbox>
                                    </v-flex>
                                </v-layout>

                            </v-card-text>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="save" :loading="loading" :disabled="loading">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        form: {},
    }),
    created() {
        eventBus.$on("openEditRole", data => {
            this.form = data
            this.form.permissions = data.permissions_arr
            this.dialog = true;
        });
    },

    methods: {
        select_permission() {
            this.selected = [];
            // console.log(sel)
            this.form.permissions.forEach(sel => {
                this.permissions.forEach(perm => {
                    this.selected.push(perm.name);
                });
            });
        },
        save() {
            var payload = {
                model: 'roles',
                data: this.form,
                id: this.form.id,
            }
            this.$store.dispatch('patchItems', payload)
                .then(response => {
                    eventBus.$emit("RoleEvent")
                });
        },
        close() {
            this.dialog = false;
        }
    },
    computed: {
        loading() {
            return this.$store.getters.loading;
        },

        permissions() {
            return this.$store.getters.permissions;
        },
    },
};
</script>
