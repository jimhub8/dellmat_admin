<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Update Product</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard style="width:100%">
                            <v-flex sm12>
                                <v-card-text>
                                    <el-select v-model="form.supplier" clearable placeholder="Supplier" style="width: 100%;">
                                        <el-option v-for="item in suppliers" :key="item.id" :label="item.name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <div>
                                        <label for="">Product name</label>
                                        <el-input placeholder="Product name" v-model="form.product_name"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Sku Number</label>
                                        <el-input placeholder="Sku number" v-model="form.sku"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Pos Status</label>
                                        <el-input placeholder="Status" v-model="form.pos_status"></el-input>
                                    </div>
                                    <VDivider />
                                    <v-layout row wrap>
                                        <v-flex sm5>
                                            <el-input placeholder="Price" v-model="form.price"></el-input>
                                        </v-flex>
                                        <v-flex sm5 style="margin-left: 90px">
                                            <el-input placeholder="Quanity" v-model="form.quantity"></el-input>
                                        </v-flex>
                                    </v-layout>
                                    <el-input placeholder="Weight" v-model="form.weight"></el-input>
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
        eventBus.$on("openEditProduct", data => {
            this.form = data
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
