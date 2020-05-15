<template>
<v-app id="inspire">
    <v-navigation-drawer v-model="drawer" :clipped="clipped" app>

        <v-list dense id="navigation">
            <v-img :aspect-ratio="16/9" src="/storage/app/app_image.jpeg" >
                <v-layout pa-2 column fill-height class="lightbox white--text">
                    <v-spacer></v-spacer>
                    <v-flex shrink>
                        <div class="subheading">{{ user.name }}</div>
                        <div class="body-1">{{ user.email }}</div>
                    </v-flex>
                </v-layout>
            </v-img>
            <template>
                <v-card>
                    <router-link to="/" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>dashboard</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Dashboard</div>
                        </div>
                    </router-link>
                    <!-- <router-link to="/pos" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>book</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Pos</div>
                        </div>
                    </router-link> -->
                    <router-link to="/sales" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>shopping_cart</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Sales</div>
                        </div>
                    </router-link>

                    <router-link to="/clients" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>people_outline</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Clients</div>
                        </div>
                    </router-link>

                    <router-link to="/vendors" class="v-list-item v-list-item--link theme--light" v-if="user.is_admin">
                        <div class="v-list__tile__action">
                            <v-icon>people</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Vendors</div>
                        </div>
                    </router-link>

                    <router-link to="/withdraw" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list__tile__action">
                            <v-icon>monetization_on</v-icon>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Withdraw</div>
                        </div>
                    </router-link>

                    <v-list-group prepend-icon="shopping_basket">
                        <template v-slot:activator>
                            <v-list-item-title>Products</v-list-item-title>
                        </template>
                        <router-link to="/products" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>shopping_basket</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Products</div>
                            </div>
                        </router-link>
                        <router-link to="/menu" class="v-list-item v-list-item--link theme--light" v-if="user.is_admin">
                            <div class="v-list__tile__action">
                                <v-icon>gavel</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Menu</div>
                            </div>
                        </router-link>
                        <router-link to="/category" class="v-list-item v-list-item--link theme--light" v-if="user.is_admin">
                            <div class="v-list__tile__action">
                                <v-icon>gavel</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Categories</div>
                            </div>
                        </router-link>
                        <router-link to="/subcategory" class="v-list-item v-list-item--link theme--light" v-if="user.is_admin">
                            <div class="v-list__tile__action">
                                <v-icon>gavel</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Subcategories</div>
                            </div>
                        </router-link>

                        <router-link to="/brand" class="v-list-item v-list-item--link theme--light" v-if="user.is_admin">
                            <div class="v-list__tile__action">
                                <v-icon>branding_watermark</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Brands</div>
                            </div>
                        </router-link>
                    </v-list-group>

                    <v-list-group prepend-icon="account_circle" v-if="user.is_admin">
                        <template v-slot:activator>
                            <v-list-item-title>Users</v-list-item-title>
                        </template>
                        <router-link to="/users" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>people_outline</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Users</div>
                            </div>
                        </router-link>
                        <router-link to="/roles" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>gavel</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Roles</div>
                            </div>
                        </router-link>
                    </v-list-group>

                    <v-list-group prepend-icon="settings" v-if="user.is_admin">
                        <template v-slot:activator>
                            <v-list-item-title>Settings</v-list-item-title>
                        </template>
                        <router-link to="/currency" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>money</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Currency</div>
                            </div>
                        </router-link>
                        <router-link to="/product_option" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>book</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Product options</div>
                            </div>
                        </router-link>

                        <router-link to="/slider" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>image</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Slider</div>
                            </div>
                        </router-link>
                        <router-link to="/status" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>money</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Status</div>
                            </div>
                        </router-link>

                        <router-link to="/options" class="v-list-item v-list-item--link theme--light">
                            <div class="v-list__tile__action">
                                <v-icon>money</v-icon>
                            </div>
                            <div class="v-list-item__content">
                                <div class="v-list-item__title">Product Variants</div>
                            </div>
                        </router-link>

                    </v-list-group>
                </v-card>
            </template>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar :clipped-left="clipped" app color="blue darken-3" dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
        <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
            <img :src="logo" alt style="width: 130px; height: 60px;border-radius: 20px;" />
        </v-toolbar-title>
        <v-spacer />
        <!-- <Logout :user="user"></Logout> -->
        <form action="/logout" method="post">
            <input type="hidden" name="_token" :value="csrf">
            <v-btn type="submit">Logout</v-btn>
        </form>
        <!-- <VDivider vertical style="margin-top: 0px;" /> -->

    </v-app-bar>

    <v-snackbar :timeout="timeout" bottom :color="Snackcolor" right v-model="snackbar">
        {{ message }}
        <v-icon dark right>{{ icon }}</v-icon>
    </v-snackbar>
    <v-footer style="background: #e2e0e0 !important;" app>
        <span style="color: #000; margin: auto;">Jimmy pos &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
    <!-- <myDrawerOpen :user="user"></myDrawerOpen> -->

</v-app>
</template>

<script>
// // import Logout from "./Logout";
// import myDrawerOpen from '../drawer/Drawer'
export default {
    components: {
        // Logout,
        // myDrawerOpen
    },
    props: ["user"],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            role: "",
            Snackcolor: '',
            color: "#1867c0",
            clipped: false,
            loading: false,
            dialog: false,
            mini_drawer: true,
            drawer: true,
            drawerRight: false,
            right: null,
            mode: "",
            company: {},
            AllBranches: [],
            Allcustomers: [],
            AllDrivers: [],
            snackbar: false,
            timeout: 5000,
            message: "Success",
            fullscreenLoading: false,
            icon: "",
            logo: process.env.MIX_LOGO,
            app_name: process.env.MIX_APP_NAME,
        };
    },
    methods: {
        openShipment() {
            this.dialog = true;
            this.getBranch();
            this.getCustomer();
            this.getDrivers();
        },

        getCustomer() {
            axios
                .get("/getCustomer")
                .then(response => {
                    this.Allcustomers = response.data;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        getDrivers() {
            axios
                .get("/getDrivers")
                .then(response => {
                    this.AllDrivers = response.data;
                })
                .catch(error => {
                    // console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        getBranch() {
            axios
                .get("/getBranchEger")
                .then(response => {
                    this.AllBranches = response.data;
                })
                .catch(error => {
                    // console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        close() {
            this.dialog = false;
        },

        showalert(data) {
            // this.message = data;
            // this.Snackcolor = "indigo";
            // this.snackbar = true;

            this.$message({
                type: 'success',
                message: data
            });
        },
        showError(data) {
            // this.message = data;
            // this.Snackcolor = "indigo";
            // this.snackbar = true;

            this.$message({
                type: 'error',
                message: data
            });
        },
        openFullScreen() {
            this.loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        closeFullScreen() {
            this.loading.close();
        }
    },
    created() {
        eventBus.$on("progressEvent", data => {
            this.$refs.topProgress.start();
        });
        eventBus.$on("StoprogEvent", data => {
            this.$refs.topProgress.done();
        });
        eventBus.$on("alertRequest", data => {
            this.showalert(data)
        });
        eventBus.$on("errorEvent", data => {
            this.showError(data)
        });
        eventBus.$on("LoadingEvent", data => {
            // this.openFullScreen(data)
        });
        eventBus.$on("stopLoadingEvent", data => {
            // this.closeFullScreen(data)
        });
    },
    computed: {
        // loadpage() {
        //     if(this.$store.getters.isLoading) {
        //         return this.openFullScreen()
        //     }
        //     return this.$store.getters.isLoading
        // }
    },

};
</script>

<style scoped>
.v-expansion-panel__container:hover {
    border-radius: 10px !important;
    width: 90% !important;
    margin-left: 15px !important;
    background: #e3edfe !important;
    color: #1a73e8 !important;
}

.theme--light {
    background-color: #212120 !important;
    /* background: url('storage/logo1.jpg') !important; */
    color: #fff !important;
}

.v-toolbar[data-booted=true] {
    transition: .2s cubic-bezier(.4, 0, .2, 1);
    z-index: 100 !important;
}

.theme--light[data-v-67cb1297] {
    z-index: 101 !important;
}

.theme--dark.v-btn:not(.v-btn--text):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: transparent !important;
}

.theme--light.v-application {
    /* margin-top: -650px; */
}
</style>
