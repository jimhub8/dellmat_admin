<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Box</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard>
                            <v-flex sm12>
                                <v-card-text>

                                    <el-select v-model="form.client_type" clearable placeholder="Supplier" style="width: 100%;">
                                        <el-option v-for="item in suppliers" :key="item.value" :label="item.label" :value="item.value">
                                        </el-option>
                                    </el-select>
                                    <div v-if="form.payment === 'Corporate'">
                                        <label for="">Full Name of Contact at the Company</label>
                                        <el-input placeholder="company contact" v-model="form.name"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Email Address</label>
                                        <el-input placeholder="email" v-model="form.email"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Phone Number</label>
                                        <el-input placeholder="number" v-model="form.phone"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Address</label>
                                    </div>
                                    <VDivider />
                                    <v-layout row wrap>
                                        <v-flex sm5>
                                            <el-input placeholder="Street address" v-model="form.address"></el-input>
                                        </v-flex>
                                        <v-flex sm5 style="margin-left: 87px">
                                            <el-input placeholder="Address Line 2" v-model="form.address_2"></el-input>
                                        </v-flex>
                                    </v-layout>
                                    <el-input placeholder="Work phone" v-model="form.work_phone"></el-input>
                                    <v-layout row wrap>
                                        <v-flex sm5>
                                            <el-input placeholder="City" v-model="form.city"></el-input>
                                        </v-flex>
                                        <v-flex sm5 style="margin-left: 87px">
                                            <el-input placeholder="Zip Code" v-model="form.zip_code"></el-input>
                                        </v-flex>
                                    </v-layout>
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
        form: [],
    }),
    created() {
        eventBus.$on("openCreateProduct", data => {
            this.form = data
            this.dialog = true;
        });
    },

    methods: {
        save() {
            eventBus.$emit("LoadingEvent");
            this.loading = true;
            axios
                .post("products", this.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    // this.$store.dispatch('getProducts');
                    eventBus.$emit('productEvent')
                    this.$store.dispatch('alertEvent', 'Client added')
                    // this.close();
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                        eventBus.$emit('reloadRequest', error.response.statusText)
                    } else if (error.response.status === 422) {
                        eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                        return
                    }
                });
        },
        close() {
            this.dialog = false;
        }
    },
    computed: {
        suppliers() {
            return this.$store.dispatch('suppliers')
        }
    },
};
</script>
