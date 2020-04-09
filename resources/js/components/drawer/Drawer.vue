<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Drawer Opening Amount</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <div>
                                <label for="">Opening Amount</label>
                                <el-input placeholder="0" v-model="form.opening_amount"></el-input>
                            </div>
                            <div>
                                <label for="">Remark</label>
                                <el-input type="textarea" placeholder="Please input" v-model="form.opening_remark" maxlength="200" show-word-limit>
                                </el-input>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" @click="openStore">Open Store</v-btn>
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
        form: {},
        payload: {
            model: 'drawers',
        },
    }),
    created() {
        eventBus.$on("openCreateDrawer", data => {
            this.dialog = true;
        });
    },

    methods: {
        openStore() {
            this.payload['data'] = this.form
            this.$store.dispatch('postItems', this.payload)
                .then((res) => {
                    this.dialog = false
                })
        },
        close() {
            this.dialog = false;
        }
    },
    mounted() {
        this.dialog = !this.user.drawer_open;
    },
};
</script>
