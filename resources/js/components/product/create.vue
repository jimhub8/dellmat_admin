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

                        <v-flex sm12>
                            <label for="">Vendor</label>
                            <el-select v-model="form.seller_id" filterable placeholder="type at least 3 characters" :loading="loading" style="width: 100%">
                                <el-option v-for="item in sellers.data" :key="item.id" :label="item.name" :value="item.id">
                                </el-option>
                            </el-select>
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
    props: ['user'],
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
            this.getSellers();
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
        },

        getSellers() {
            var payload = {
                model: '/seller/sellers',
                update_list: 'updateSellerList',
            }
            this.$store.dispatch("getItems", payload);
        },

        // getVendors(search) {
        //     // console.log(search);
        //     if (search.length > 2) {
        //         var payload = {
        //             model: '/seller/sellers',
        //             update_: 'updateClientList',
        //             search: search
        //         }
        //         this.$store.dispatch("searchItems", payload);
        //     }
        // }
    },
    computed: {
        sellers() {
            return this.$store.getters.sellers;
        },
        loading() {
            return this.$store.getters.loading;
        }
    },
};
</script>
