<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <div class="hide-overflow" style="position: relative;padding:20px" v-if="products.data.length > 0">
                <v-row>
                    <v-col cols="12" sm="12">
                        <v-toolbar-title>
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getItems">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-toolbar-title>
                        <!-- <vue-fuse :keys="keys" class="form-control" :list="products.data" :defaultAll="false" :eventName="filteredList"></vue-fuse> -->
                        <input type="text" class="form-control" v-model="search" @keyup.enter="filteredList">
                    </v-col>

                    <myProduct v-show="products_show"></myProduct>

                    <myCustomer v-show="client_show"></myCustomer>

                    <v-col cols="12" sm="4" style="z-index: 0; float: right">
                        <myCart></myCart>
                    </v-col>
                </v-row>
            </div>
            <myEmpty v-else></myEmpty>
            <v-flex sm12 v-show="products_show">
                <v-pagination v-model="products.current_page" :length="products.last_page" total-visible="5" @input="next_page(products.path, products.current_page)" circle v-if="products.last_page > 1"></v-pagination>
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
import myProduct from './inc/product'
import myCustomer from './inc/customers'
import myCart from './inc/cart'
import myEmpty from './inc/empty_products'
export default {
    props: ['user'],
    components: {
        myCart,
        myCustomer,
        myProduct,
        myEmpty
    },
    data() {
        return {
            form: {},
            products_show: true,
            client_show: false,
            loader: false,
            search: "",
            payload: {
                model: 'products',
                update_list: 'updateProductsList'
            },
            products_search: [],
            keys: ["name", "id"],
            searchResults: [],
        };
    },
    methods: {
        openCreate() {
            eventBus.$emit("openCreateProduct");
        },
        openEdit(data) {
            eventBus.$emit("openEditProduct", data.row);
        },
        updateQty(data) {
            eventBus.$emit("updateQtyEvent", data);
        },

        confirm_delete(item) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.deleteItem(item)
            }).catch(() => {
                this.$message({
                    type: 'error',
                    message: 'Delete canceled'
                });
            });
        },

        openShow(data) {
            eventBus.$emit("openShowProduct", data);
        },
        getItems() {
            this.$store.dispatch("getItems", this.payload);
        },

        getClients() {
            var payload = {
                model: 'clients',
                update_list: 'updateClientList'
            }
            this.$store.dispatch("getItems", payload);
        },
        getDiscount() {
            var payload = {
                model: 'discounts',
                update_list: 'updateDiscountList'
            }
            this.$store.dispatch("getItems", payload);
        },
        updateSelected(url) {
            // alert('test')
            if (this.checkedRows.length < 1) {
                eventBus.$emit("errorEvent", "Please select atleast one row");
                return;
            }

            this.$store
                .dispatch("updateSelected", {
                    url,
                    checked: this.checkedRows
                })
                .then(response => {
                    eventBus.$emit("alertRequest", "Updated");
                    this.checkedRows = [];
                    this.getItems();
                });
        },
        selectionChanged(params) {
            this.checkedRows = params.selectedRows;
        },
        openCustomers() {
            this.products_show = false
            this.client_show = true
        },
        openProduct() {
            this.products_show = true
            this.client_show = false
        },

        next_page(path, page) {
            var payload = {
                path: path,
                page: page,
                update_list: 'updateProductsList'
            }
            this.$store.dispatch("nextPage", payload);
        },
        productChange() {
            this.$search(this.term, this.products, this.options).then(results => {
                this.searchResults = results
            })
        },

        filteredList() {
            var payload = {
                search: this.search,
                model: 'product_search',
                update_: 'updateProductsList'
            }
            this.$store.dispatch("searchItems", payload);
        },
    },
    computed: {

        products() {
            return this.$store.getters.products;
        },

        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        // this.$store.dispatch('getItems');
        eventBus.$emit("LoadingEvent");
        this.getClients();
        this.getDiscount();
        this.getItems();
    },
    created() {
        eventBus.$on("productEvent", data => {
            this.getItems();
        });

        eventBus.$on("clientEvent", data => {
            this.getClients();
        });
        eventBus.$on("openProductEvent", data => {
            this.openProduct();
        });

        eventBus.$on("openPageEvent", data => {
            if (data == 'product') {
                this.openProduct()
            } else if (data == 'customer') {
                this.openCustomers()
            }
        });

        eventBus.$on("responseChooseEvent", data => {
            console.log(data);
            if (data == "Excel") {
                eventBus.$emit("openEditProduct");
            } else {
                eventBus.$emit("openCreateProduct");
            }
        });

        // eventBus.$on("selectClient", data => {
        //     this.form.client_id = data.id
        //     this.customer_name = data.name
        // });

    },

    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view products"]) {
    //         next();
    //       } else {
    //         next("/");
    //       }
    //     });
    //   }
};
</script>

<style scoped>
.el-input--prefix .el-input__inner {
    border-radius: 50px !important;
}

.v-toolbar__content,
.v-toolbar__extension {
    height: auto !important;
}

#address_tab span {
    font-style: inherit;
    font-weight: inherit;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 200px;
    overflow: hidden;
    display: block;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
