<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Products</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <!-- <myFilter :form="form" :user="user" style></myFilter> -->
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getItems">
                                        <v-icon color="blue darken-2" small>refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm2>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Products</h3>
                        </v-flex>
                        <v-flex offset-sm8 sm2>
                            <v-btn color="info" @click="openCreate" text>Create Product</v-btn>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-pagination v-model="products.current_page" :length="products.last_page" total-visible="5" @input="next_page(products.path, products.current_page)" circle v-if="products.last_page > 1"></v-pagination>
            </v-flex>
            <v-flex sm12>
                <vue-good-table class="table-hover" :columns="columns" :rows="products.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" v-loading="isLoading" :sort-options="{enabled: true, initialSortBy: {field: 'product_name', type: 'asc'}}" :select-options="{ enabled: true }" @on-row-dblclick="openEdit" @on-selected-rows-change="selectionChanged" :selectOptions="{ enabled: true, selectOnCheckboxOnly: true}">
                    <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'created_at'">
                            <span>
                                <el-tag type="success">{{props.formattedRow.created_at}}</el-tag>
                            </span>
                        </span>
                         <span v-else-if="props.column.field == 'variants'">
                            <span>
                                <el-tag type="danger">{{props.row.variants}}</el-tag>
                            </span>
                        </span>
                         <span v-else-if="props.column.field == 'price'">
                            <span>
                                <el-tag type="info">{{props.row.price}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'description'" id="address_tab">
                            <el-tooltip class="item" effect="dark" :content="props.row.description" placement="top-start">
                                <span>
                                    {{ props.row.description }}
                                </span>
                            </el-tooltip>
                        </span>
                        <span v-else-if="props.column.field == 'actions'">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon class="mx-0" @click="openEdit(props)" slot="activator">
                                        <v-icon small color="blue darken-2">edit</v-icon>
                                    </v-btn>
                                </template>
                                <span>Edit {{ props.row.product_name }}</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" class="mx-0" @click="updateQty(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">shopping_basket</v-icon>
                                    </v-btn>
                                </template>
                                <span>Update {{ props.row.product_name }} quantity</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" class="mx-0" @click="updateImg(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">image</v-icon>
                                    </v-btn>
                                </template>
                                <span>Update {{ props.row.product_name }} quantity</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" class="mx-0" @click="confirm_delete(props.row)" slot="activator">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Delete {{ props.row.product_name }}</span>
                            </v-tooltip>


                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" class="mx-0" @click="openShow(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">visibility</v-icon>
                                    </v-btn>
                                </template>
                                <span>show {{ props.row.product_name }}</span>
                            </v-tooltip>
                        </span>
                        <span v-else>{{ props.formattedRow[props.column.field] }}</span>
                    </template>
                </vue-good-table>
            </v-flex>
        </v-layout>
    </v-container>
    <Create></Create>
    <myImage></myImage>
    <myShow></myShow>
</v-content>
</template>

<script>
import Create from "./create";
import myImage from './image'
import myShow from './product_details'
export default {
    props: ['user'],
    components: {
        Create,
        myImage, myShow
    },
    data() {
        return {
            form: {},
            loader: false,
            search: "",
            payload: {
                model: 'product_table',
                update_list: 'updateProductsList'
            },
            products_det: {
                data: []
            },
            products_search: [],
            temp: "",
            checkedRows: [],
            columns: [{
                    label: 'name',
                    field: 'product_name',
                },
                {
                    label: 'Sku no.',
                    field: 'sku_no',
                },
                {
                    label: 'Price',
                    field: 'price',
                },
                {
                    label: 'Available Stoke',
                    field: 'quantity',
                },
                {
                    label: 'Variants',
                    field: 'variants',
                },
                {
                    label: "Created On",
                    field: "created_at",
                    // type: "date",
                    // dateInputFormat: "YYYY-MM-DD",
                    // dateOutputFormat: "Do MMMM YYYY"
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false
                }
            ],
        };
    },
    methods: {
        openCreate() {
            eventBus.$emit("openCreateProduct");
        },
        openEdit(data) {
            // eventBus.$emit("openEditProduct", data.row);

            this.$router.push({
                name: "editProduct",
                params: {
                    id: data.row.id
                }
            });
        },
        updateQty(data) {
            eventBus.$emit("updateQtyEvent", data);
        },
        updateImg(data) {
            eventBus.$emit("openImageEvent", data);
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

        deleteItem(item) {
            this.$store.dispatch("deleteItem", "products/" + item.id).then(response => {
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
                this.getItems();
            });
        },
        openShow(data) {
            eventBus.$emit("openShowProduct", data);
        },
        getItems() {
            this.$store.dispatch("getItems", this.payload);
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

        next_page(path, page) {
            var payload = {
                path: path,
                page: page,
                update_list: 'updateProductsList'
            }
            this.$store.dispatch("nextPage", payload);
        }
    },
    computed: {
        products() {
            return this.$store.getters.products;
        },

        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getItems');
        eventBus.$emit("LoadingEvent");
        this.getItems();
    },
    created() {
        eventBus.$on("productEvent", data => {
            this.getItems();
        });

        eventBus.$on("responseChooseEvent", data => {
            console.log(data);
            if (data == "Excel") {
                eventBus.$emit("openEditProduct");
            } else {
                eventBus.$emit("openCreateProduct");
            }
        });
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

input[type=checkbox] {
    position: relative !important;
    cursor: pointer !important;
}

/* input[type=checkbox]:before {
    content: "" !important;
    display: block !important;
    position: absolute !important;
    width: 16px !important;
    height: 16px !important;
    top: 0 !important;
    left: 0 !important;
    border: 2px solid #555555 !important;
    border-radius: 3px !important;
    background-color: white !important;
}

input[type=checkbox]:checked:after {
    content: "" !important;
    display: block !important;
    width: 5px !important;
    height: 10px !important;
    border: solid black !important;
    border-width: 0 2px 2px 0 !important;
    -webkit-transform: rotate(45deg) !important;
    -ms-transform: rotate(45deg) !important;
    transform: rotate(45deg) !important;
    position: absolute !important;
    top: 2px !important;
    left: 6px !important;
} */
</style>
