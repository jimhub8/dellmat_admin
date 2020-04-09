<template>
<v-row>

    <v-col cols="12" sm="12">
        <v-toolbar dense>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Customers</v-toolbar-title>

            <v-spacer></v-spacer>

            <VBtn text icon color="primary" @click="openProduct">
                <VIcon>close</VIcon>
            </VBtn>
        </v-toolbar>
    </v-col>

    <v-col cols="6" sm="6" style="margin-top: -355px;">
        <v-hover v-slot:default="{ hover }" open-delay="200">
            <v-card :elevation="hover ? 16 : 2" class="mx-auto">
                <v-card-text>
                    <ul class="cart_details list-group">
                        <li class="list-group-item" v-for="item in clients.data" :key="item.id" @click="select_client(item)">
                            <div class="cart-product-content">
                                <div class="product-name">
                                    {{ item.name }}
                                    <!---->
                                </div>
                                <div class="product-qty"><span>
                                        {{ item.email }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </v-card-text>
            </v-card>
        </v-hover>
    </v-col>

    <v-col cols="6" sm="6" style="margin-top: -355px;">
        <v-hover v-slot:default="{ hover }" close-delay="200">
            <v-card :elevation="hover ? 16 : 2" class="mx-auto">
                <v-card-text v-if="!selected" style="text-align: center;">
                    <h4>Add Client</h4>
                    <!-- <v-btn depressed small color="primary" disabled>Edit</v-btn> -->
                    <VBtn icon color="primary" @click="openCreate">
                        <VIcon>add</VIcon>
                    </VBtn>
                </v-card-text>

                <v-card-text v-else style="text-align: center;">
                    <v-icon dark large>mdi-account-circle</v-icon>
                    <h3 class="text-danger">{{ selected_client.name }}</h3>
                    <small>{{ selected_client.email }}</small>
                    <v-btn block color="primary" dark @click="s_client">Select Customer</v-btn>
                    <!-- <v-btn depressed small color="primary" disabled>Edit</v-btn> -->
                    <v-divider></v-divider>
                    <v-btn rounded color="primary" text @click="openEdit">Edit
                        <v-icon right dark small>edit</v-icon>
                    </v-btn>

                    <VSpacer />
                    <VBtn icon color="primary" @click="openCreate">
                        <VIcon>add</VIcon>
                    </VBtn>
                </v-card-text>
            </v-card>
        </v-hover>
    </v-col>
    <create></create>
    <edit></edit>
</v-row>
</template>

<script>
import create from '../../clients/create'
import edit from '../../clients/edit'
export default {
    components: {
        create,
        edit
    },
    data() {
        return {
            open_client: false,
            selected: false,
            selected_client: {},
        }
    },
    methods: {
        select_client(item) {
            this.selected_client = item
            this.selected = true
        },
        s_client() {
            eventBus.$emit('selectClient', this.selected_client)
        },
        openCreate() {
            eventBus.$emit("openCreateClient");
            var payload = {
                model: 'groups',
                update_list: 'updateGroupList',
            }
            this.$store.dispatch("getItems", payload);
        },
        openEdit() {
            eventBus.$emit("openEditClient", this.selected_client);
        },

        openProduct() {
            eventBus.$emit("openProductEvent");

        },
        getClients() {
            payload = {
                model: 'clients',
                update_list: 'updateClientList'
            },
            this.$store.dispatch("getItems", payload);
        },

    },
    computed: {
        clients() {
            return this.$store.getters.clients

        },
    },
    created() {

        eventBus.$on("clientEvent", data => {
            this.getClients();
        });

        eventBus.$on("openPageEvent", data => {
            if (data == 'product') {
                this.open_client = true
            } else if (data == 'customer') {
                this.open_client = false
            }
        });
    },
}
</script>

<style scoped>
li {
    background: #f9f9f9;
    cursor: pointer;
}

li:nth-child(odd) {
    cursor: pointer;
    background: #fceff3;
}
</style>
