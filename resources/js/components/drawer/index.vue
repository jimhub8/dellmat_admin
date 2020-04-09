<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-tooltip right>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" slot="activator" class="mx-0" @click="getDrawer">
                        <v-icon color="blue darken-2" small>refresh</v-icon>
                    </v-btn>
                </template>
                <span>Refresh</span>
            </v-tooltip>
            <el-row :gutter="12" style="width: 100%">
                <el-col :span="8">
                    <el-card shadow="hover">
                        <h5>Opening Amount</h5>
                        KES {{ drawers.opening_amount }}
                        <v-divider></v-divider>
                        <b>Today's total cash sale</b>
                        <p>KES {{ drawers.total }}</p>

                        <b>Discounts</b>
                        <p style="color: red">KES {{ drawers.discount }}</p>

                        <b>Expected Amount In Drawer</b>
                        <p style="color: red">KES {{ drawers.expected_closing_amount }}</p>
                    </el-card>
                </el-col>
                <el-col :span="8">
                    <el-card shadow="hover">
                        <h3>Counted Drawer Amount</h3>
                        <div>
                            <label for="">Amount</label>
                            <el-input placeholder="Amount" type="number" v-model="form.drawer_amount"></el-input>
                        </div>
                        <div>
                            <label for="">Remark</label>
                            <el-input type="textarea" placeholder="Please input" v-model="form.remark" maxlength="200" show-word-limit>
                            </el-input>
                        </div>
                    </el-card>
                </el-col>
                <el-col :span="8">
                    <el-card shadow="hover">
                        <h3>Closing Drawer Details</h3>
                        <p>Difference</p>
                        <p>{{ parseInt(drawers.total) + parseInt(drawers.opening_amount) - parseInt(form.drawer_amount)  }}</p>
                        <v-btn color="primary" text @click="save">Close Drawer</v-btn>
                    </el-card>
                </el-col>
            </el-row>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    data() {
        return {
            form: {
                drawer_amount: 0,
                remark: ''
            },

            payload: {
                model: 'drawers',
                update_list: 'updateDrawerList'
            },
        }
    },
    methods: {
        getDrawer() {
            this.$store.dispatch("getItems", this.payload);
        },
        save() {
            this.form.sale_total = this.drawers.total
            var payload = {
                model: 'drawers',
                data: this.form,
                id: this.drawers.id,
            }
            this.$store.dispatch('patchItems', payload)
                .then(response => {
                    location.reload();
                    // eventBus.$emit("clientEvent")
                });
        },
    },
    mounted() {
        this.getDrawer();
    },

    computed: {
        drawers() {
            return this.$store.getters.drawers
        }
    },

}
</script>
