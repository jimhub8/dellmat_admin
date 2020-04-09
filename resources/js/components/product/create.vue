<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Product</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <div>
                                <label for="">Product name</label>
                                <el-input placeholder="Product name" v-model="form.product_name"></el-input>
                            </div>
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
        loading: false,
        form: {
            description: '',
            name: '',
            pos_status: '',
            price: '',
            product_barcode: '',
            quantity: '',
            sku: '',
            tax_category_id: '',
            tax_percent: '',
            type: '',
            weight: '',
        },
    }),
    created() {
        eventBus.$on("openCreateProduct", data => {
            this.dialog = true;
            this.$store.dispatch('getItems', ['suppliers', 'updateSupplierList'])
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
