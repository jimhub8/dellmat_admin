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
                                    <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getProducts">
                                        <v-icon color="blue darken-2" small>refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm3>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Product options</h3>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(option, index) in options" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ option.name }}</td>
                            <td>3</td>
                            <td>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn v-on="on" icon class="mx-0" @click="openEdit(option.name)" slot="activator">
                                            <v-icon small color="blue darken-2">edit</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Edit</span>
                                </v-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </v-flex>
        </v-layout>
    </v-container>
    <myBest></myBest>
    <myNew></myNew>
    <myFeatured></myFeatured>
</v-content>
</template>

<script>
import myFeatured from './featured'
import myBest from './bestsellers'
import myNew from './newproduct'
export default {

    props: ['user'],
    components: {
        myFeatured, myNew, myBest
    },
    data() {
        return {
            options: [{
                    name: 'Featured tems',
                },
                {
                    name: 'Best sellers',
                },
                {
                    name: 'New products',
                }
            ],
            search: "",
            payload: {
                model: 'menu',
                update_list: 'updateMenuList'
            },
            columns: [{
                    label: "Description",
                    field: "name"
                },
                {
                    label: "Total",
                    field: "total"
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
        openEdit(data) {
            console.log(data);

            if (data === 'Featured tems') {
                eventBus.$emit("openFeatured");

            }

            if (data === 'Best sellers') {
                eventBus.$emit("openBest");

            }
            if (data === 'New products') {
                eventBus.$emit("openNew");

            }
        },

        product_settings() {
            
        }

    },
    computed: {
        menu() {
            return this.$store.getters.menu;
        },
        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getProducts');
        eventBus.$emit("LoadingEvent");
    },
    created() {
    },

    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view menu"]) {
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
