<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">OFFER DETAILS</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <v-card-text>
                                <v-layout row wrap>
                                    <VFlex sm6>
                                        <label for="">Offer Name</label>
                                        <el-input placeholder="Discount name" v-model="form.offer_name"></el-input>
                                    </VFlex>
                                    <VFlex sm6>
                                        <label for="">Offer display name</label>
                                        <el-input placeholder="Discount name" v-model="form.offer_display_name"></el-input>
                                    </VFlex>

                                    <VFlex sm6>
                                        <label for="">Offer Start date</label>
                                        <el-date-picker style="width: 100%" v-model="form.start_date" type="date" placeholder="Pick a day">
                                        </el-date-picker>
                                    </VFlex>
                                    <VFlex sm6>
                                        <label for="">Offer End date</label>
                                        <el-date-picker style="width: 100%" v-model="form.end_date" type="date" placeholder="Pick a day">
                                        </el-date-picker>
                                    </VFlex>
                                </v-layout>
                                <v-divider></v-divider>

                            </v-card-text>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-text>

                <v-layout row wrap>
                    <v-flex sm12>
                        <discount_type :form="form"></discount_type>
                    </v-flex>
                    <v-flex sm12>
                        <customer_group></customer_group>
                    </v-flex>
                    <v-flex sm12>
                        <availability></availability>
                    </v-flex>
                </v-layout>

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
import discount_type from './inc/discount_type'
import availability from './inc/availability'
import customer_group from './inc/customer_group'
export default {
    components: {
        discount_type,
        availability,
        customer_group
    },
    data: () => ({
        dialog: false,
        loading: false,
        form: {},
        payload: {
            model: 'discounts',
        },

        options: [{
            value: 'Fixed',
            label: 'Fixed'
        }, {
            value: 'Percentage',
            label: 'Percentage'
        }],
        form: {
            discount_type: '',
            percentage_discount: '0.0%',
            category: '',
            buy_quantity: '',
            get_quantity: '',
            products: {},
            fixed_price: 'KSH 0.00'
        },
    }),

    created() {
        eventBus.$on("openCreateDiscount", data => {
            this.dialog = true;
            this.getCategories()
        });
    },

    methods: {
        getCategories() {
            var payload = {
                model: 'categories',
                update_list: 'updateCategoryList'
            }
            this.$store.dispatch("getItems", payload);
        },
        // save() {
        //     this.payload['data'] = this.form
        //     this.$store.dispatch('postItems', this.payload)
        // },
        save() {
            var payload = {
                model: 'discounts',
                data: this.form,
            }
            this.$store.dispatch("postItems", payload);
        },
        close() {
            this.dialog = false;
        }
    },
};
</script>
