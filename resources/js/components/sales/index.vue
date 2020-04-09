<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Sales</el-breadcrumb-item>
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
                                    <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getSales">
                                        <v-icon color="blue darken-2" small>refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm2>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Sales</h3>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-pagination v-model="sales.current_page" :length="sales.last_page" total-visible="5" @input="next_page(sales.path, sales.current_page)" circle v-if="sales.last_page > 1"></v-pagination>
            </v-flex>
            <v-flex sm12>
                <vue-good-table class="table-hover" :columns="columns" :rows="sales.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" v-loading="isLoading" :sort-options="{enabled: true, initialSortBy: {field: 'created_at', type: 'des'}}">
                    <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'created_at'">
                            <span>
                                <el-tag type="success">{{props.formattedRow.created_at}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'sub_total'">
                            <span>
                                <el-tag type="info">{{ props.row.sub_total }}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'discount'">
                            <span>
                                <el-tag type="danger">{{ props.row.discount }}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'total'">
                            <span>
                                <el-tag>{{ props.row.total }}</el-tag>
                            </span>
                        </span>

                        <span v-else-if="props.column.field == 'status'">
                            <span>
                                <el-tag type="success">{{ props.row.status }}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'actions'">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon class="mx-0" @click="openShow(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">visibility</v-icon>
                                    </v-btn>
                                </template>
                                <span>View {{ props.row.name }}'s Order</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" icon class="mx-0" @click="openUpdate(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">update</v-icon>
                                    </v-btn>
                                </template>
                                <span>Update status {{ props.row.name }}'s Order</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" class="mx-0" @click="confirm_delete(props.row)" slot="activator">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Delete {{ props.row.name }}</span>
                            </v-tooltip>
                        </span>
                        <span v-else>{{ props.formattedRow[props.column.field] }}</span>
                    </template>
                </vue-good-table>
            </v-flex>
        </v-layout>
    </v-container>
    <myShow></myShow>
    <myUpdate></myUpdate>
</v-content>
</template>

<script>
import myShow from './Show'
import myUpdate from './Update'
export default {
    components: {
        myShow, myUpdate
    },
    props: ['user'],
    data() {
        return {
            form: {},
            loader: false,
            search: "",
            payload: {
                model: 'sales',
                update_list: 'updateSaleList'
            },
            checkedRows: [],
            columns: [{
                    label: "Created On",
                    field: "created_at",
                    // type: "date",
                    // dateInputFormat: "YYYY-MM-DD",
                    // dateOutputFormat: "Do MMMM YYYY"
                },
                {
                    label: "Client Name",
                    field: "client_name"
                },
                {
                    label: "Created By",
                    field: "user_name"
                },
                {
                    label: "Sub total",
                    field: "sub_total"
                },
                {
                    label: "Discount",
                    field: "discount"
                },
                {
                    label: "Total",
                    field: "total"
                },
                {
                    label: "Status",
                    field: "status"
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false
                }
            ]
        };
    },
    methods: {
        openShow(data) {
            eventBus.$emit("openShowSale", data);
        },

        openUpdate(data) {
            eventBus.$emit("openUpdateStatus", data);
        },

        // confirm_delete(item) {
        //     this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
        //         confirmButtonText: 'OK',
        //         cancelButtonText: 'Cancel',
        //         type: 'warning'
        //     }).then(() => {
        //         this.deleteItem(item)
        //     }).catch(() => {
        //         this.$message({
        //             type: 'error',
        //             message: 'Delete canceled'
        //         });
        //     });
        // },

        deleteItem(item) {
            this.$store.dispatch("deleteItem", "sales/" + item.id).then(response => {
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
                this.getSales();
            });
        },
        getSales() {
            this.$store.dispatch("getItems", this.payload);
        },

        next_page(path, page) {
            var payload = {
                path: path,
                page: page,
                update_list: 'updateSalesList'
            }
            this.$store.dispatch("nextPage", payload);
        }
    },
    computed: {
        sales() {
            return this.$store.getters.sales;
        },

        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getSales');
        eventBus.$emit("LoadingEvent");
        this.getSales();
    },
    created() {
        eventBus.$on("saleEvent", data => {
            this.getSales();
        });

        eventBus.$on("responseChooseEvent", data => {
            console.log(data);
            if (data == "Excel") {
                eventBus.$emit("openEditSale");
            } else {
                eventBus.$emit("openCreateSale");
            }
        });
    },

    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view sales"]) {
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

.v-avatar {
    height: 10px !important;
    width: 10px !important;
    margin-left: 40% !important;
}
</style>
