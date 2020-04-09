<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="800px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Vendor</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm6>
                            <label for="">Full Name</label>
                            <el-input placeholder="John Doe" v-model="form.name"></el-input>
                        </v-flex>
                        <v-flex sm6>

                            <label for="">Email Address</label>
                            <el-input placeholder="john@gmail.com" v-model="form.email"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Phone Number</label>
                            <el-input placeholder="+254..." v-model="form.phone"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Address</label>
                            <el-input placeholder="123 main st" v-model="form.address"></el-input>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                    <h3 class="text-center">Store details</h3>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex sm6>
                            <label for="">Store name</label>
                            <el-input placeholder="jane's store" v-model="form.company_name"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Address</label>
                            <el-input placeholder="123 mainst" v-model="form.company_address"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Address 2</label>
                            <el-input placeholder="123 mainst" v-model="form.address_2"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Store phone no.</label>
                            <el-input placeholder="jane's store" v-model="form.company_phone"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Store email</label>
                            <el-input placeholder="jane@store.com" v-model="form.company_email"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Store website</label>
                            <el-input placeholder="https://123.com" v-model="form.company_website"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Postal code</label>
                            <el-input placeholder="0003299" v-model="form.postal_code"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Business No.</label>
                            <el-input placeholder="A2415" v-model="form.business_no"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Building</label>
                            <el-input placeholder="T towers" v-model="form.building"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Floor</label>
                            <el-input placeholder="2nd floor" v-model="form.floor"></el-input>
                        </v-flex>
                        <!-- <v-flex sm6>
                            <label for="">Location</label>
                            <el-input placeholder="Luthuri st" v-model="form.floor"></el-input>
                        </v-flex> -->
                    </v-layout>

                    <v-divider></v-divider>

                    <h2 class="text-center">Payment Method</h2>
                    <v-divider></v-divider>
                    <v-radio-group v-model="form.payment_mode" :mandatory="true">
                        <v-radio label="Bank" value="bank"></v-radio>
                        <v-radio label="M-pesa" value="m_pesa"></v-radio>
                    </v-radio-group>
                    <v-layout wrap row v-if="form.payment_mode =='bank'">
                        <v-flex sm6>
                            <label for="">Bank name</label>
                            <el-input placeholder="" v-model="form.bank_name"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Account no.</label>
                            <el-input placeholder="" v-model="form.account_no"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Bank code</label>
                            <el-input placeholder="" v-model="form.bank_code"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Bank branch</label>
                            <el-input placeholder="" v-model="form.branch"></el-input>
                        </v-flex>
                    </v-layout>

                    <v-layout wrap row v-else>
                        <v-flex sm6>
                            <label for="">Mpesa registration name</label>
                            <el-input placeholder="" v-model="form.mpesa_reg_name"></el-input>
                        </v-flex>
                        <v-flex sm6>
                            <label for="">Account no.</label>
                            <el-input placeholder="+254..." v-model="form.mpesa_phone"></el-input>
                        </v-flex>
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
            name: '',
            email: '',
            phone: '',
            address: '',
            company_name: '',
            company_email: '',
            company_phone: '',
            company_address: '',
            business_no: '',
            company_website: '',
            account_no: '',
            account_name: '',
            mpesa_name: '',
            mpesa_phone: '',
            payment_mode: 'bank'
        },
        errors: {},
        gender: [{
                value: 'Male',
                lable: 'Male',
            },
            {
                value: 'Female',
                lable: 'Female',
            },
        ]
    }),
    created() {
        eventBus.$on("openCreateSeller", data => {
            this.dialog = true;
        });
    },

    methods: {
        save() {
            var payload = {
                data: this.form,
                model: '/seller/sellers',
            }
            this.$store.dispatch('postItems', payload)
                .then(response => {
                    eventBus.$emit("sellerEvent")
                });
        },
        close() {
            this.dialog = false;
        }
    },
    computed: {
        suppliers() {
            return this.$store.dispatch('suppliers')
        },

        groups() {
            return this.$store.getters.groups;
        },
    },
};
</script>
