<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Edit User</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <v-card-text>
                                <div>
                                    <label for="">Name</label>
                                    <el-input placeholder="Jane Doe" v-model="form.name"></el-input>
                                </div>
                                <div>
                                    <label for="">Email</label>
                                    <el-input placeholder="jane@gmail.com" v-model="form.email"></el-input>
                                </div>
                                <div>
                                    <label for="">Phone No.</label>
                                    <el-input placeholder="+254..." v-model="form.phone"></el-input>
                                </div>
                                <div>
                                    <label for="">Address</label>
                                    <el-input placeholder="123 main street" v-model="form.address"></el-input>
                                </div>

                                <v-checkbox label="active" v-model="form.active_status" value="true"></v-checkbox>

                                <label for="">Role</label>
                                <el-select v-model="form.role" filterable clearable placeholder="Role" style="width: 100%;">
                                    <el-option v-for="item in roles" :key="item.id" :label="item.name" :value="item.id">
                                    </el-option>
                                </el-select>
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
        eventBus.$on("openEditUser", data => {
            this.form = data
            this.dialog = true;
        });
    },

    methods: {
        save() {
            var payload = {
                model: 'users',
                data: this.form,
                id: this.form.id,
            }
            this.$store.dispatch('patchItems', payload)
                .then(response => {
                    eventBus.$emit("UserEvent")
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

        roles() {
            return this.$store.getters.roles;
        },
    },
};
</script>
