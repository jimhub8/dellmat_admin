<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Client</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard>
                            <v-flex sm12>
                                <v-card-text>
                                    <div>
                                        <label for="">Full Name</label>
                                        <el-input placeholder="John Doe" v-model="form.name"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Email Address</label>
                                        <el-input placeholder="john@gmail.com" v-model="form.email"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Phone Number</label>
                                        <el-input placeholder="+254..." v-model="form.phone"></el-input>
                                    </div>
                                    <label for="">Gender</label>
                                    <el-select v-model="form.gender" filterable clearable placeholder="Gender" style="width: 100%;">
                                        <el-option v-for="item in gender" :key="item.value" :label="item.label" :value="item.value">
                                        </el-option>
                                    </el-select>
                                    <label for="">Group</label>
                                    <el-select v-model="form.group_id" filterable clearable placeholder="Gender" style="width: 100%;">
                                        <el-option v-for="item in groups.data" :key="item.id" :label="item.group_name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-card-text>
                            </v-flex>
                        </VCard>
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
        loading: false,
        form: {},
        errors: {},
        payload: {
            model: 'clients',
        },
        gender: [{
                value: 'Male',
                lable: 'Male',
            },
            {
                value: 'Female',
                lable: 'Female',
            },
        ]
    }),
    created() {
        eventBus.$on("openCreateClient", data => {
            this.dialog = true;
        });
    },

    methods: {
        save() {
            this.payload['data'] = this.form
            this.$store.dispatch('postItems', this.payload)
                .then(response => {
                    eventBus.$emit("clientEvent")
                });
        },
        close() {
            this.dialog = false;
        }
    },
    computed: {
        suppliers() {
            return this.$store.dispatch('suppliers')
        },

        groups() {
            return this.$store.getters.groups;
        },
    },
};
</script>
