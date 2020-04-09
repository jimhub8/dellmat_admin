<template>
<VCard>
    <div class="pos-cart-container" style="height: 742px;">
        <div class="pos-content">
            <div class="cart">
                <div class="cart-header">
                    <v-toolbar dark color="primary">
                        <h4>Cart Details</h4>
                    </v-toolbar>
                </div>
                <div class="pos-nav-content">
                    <div id="cart_count_0" class="pos-nav-pane active">
                        <ul class="cart_details">
                            <div style="margin-top: 30px;">
                                <li class="" v-for="(item, index) in cart_item.cart" :key="item.sku_no">
                                    <div class="cart-product-content">
                                        <div class="product-name">
                                            {{ item.product_name }}
                                            <div v-if="item.choices">
                                                <ul style="display: flex;" id="choice_details">
                                                    <li v-for="(choice, index_v) in item.choices" :key="index_v">
                                                        <el-tag>{{ choice }}</el-tag>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!---->
                                        </div>
                                        <div class="product-qty"><span>
                                                <span class="qty-minus">
                                                    <i class="fa fa-minus-circle" @click="reduce(item, index)"></i>
                                                </span>
                                                {{ item.ordered }} Unit(s)
                                                <span class="qty-plus"><i class="fa fa-plus-circle" @click="addCart(item)"></i></span>
                                                - KES {{ item.price }} per unit
                                            </span>
                                        </div>
                                    </div>
                                    <div class="cart-product-price">
                                        <span>
                                            <i class="fa fa-times-circle" @click="remove(index)"></i>
                                        </span>
                                        <span>
                                            KES {{ item.ordered * item.price }}
                                        </span>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="cart-total-container">
                <div class="cart-total">
                    <div class="pos-table-responsive cart-totals">
                        <table class="pos-table">
                            <tbody>
                                <tr>
                                    <td class="text-left">Sub Total</td>
                                    <td id="subtotal" class="text-right">
                                        KES{{ getSubTotal }}
                                    </td>
                                </tr>
                                <v-divider></v-divider>
                                <tr>
                                    <!-- <td class="text-left">Discount</td> -->
                                    <td id="select_discount" class="text-left">
                                        Cash Discount KES
                                        <!-- <i class="fa fa-caret-down" @click="openDiscount"></i></td> -->
                                        <el-select v-model="form.discount_type" placeholder="Select" style="width: 100%">
                                            <el-option v-for="item in discounts.data" clearable :key="item.id" :label="item.discount_type" :value="item.discount_type">
                                            </el-option>
                                        </el-select>
                                    </td>
                                    <td id="discount" class="text-right"><input type="text" v-model="form.discount" class="control" style="margin-top: 22px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td id="taxname" class="text-left">Tax Total</td>
                                    <td id="tax" class="text-right">KES 0.00</td>
                                </tr>
                                <tr class="hide">
                                    <td class="text-left">Home Delivery</td>
                                    <td class="text-right"><input type="number" placeholder="" class="form-field"></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Grand Total</td>
                                    <td class="text-right">KES {{ getTotal }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div>
                            <small style="color: red" v-if="errors.cart">{{ errors.cart[0] }}</small>
                        </div>
                    </div>
                </div>
                <v-divider></v-divider>
                <div class="cart-button-container pos-action">
                    <!-- <el-select v-model="form.client" multiple filterable remote reserve-keyword placeholder="type at least 3 characters" :remote-method="getClient" :loading="loading" style="width: 100%;">
                        <el-option v-for="item in clients.data" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select> -->
                    <v-btn rounded color="primary" @click="openClient" v-if="customer_name == null">Customer
                        <v-icon right dark small>edit</v-icon>
                    </v-btn>
                    <v-btn rounded color="primary" @click="openClient" v-else>{{ customer_name }}
                        <v-icon right dark small>edit</v-icon>
                    </v-btn>

                    <!-- <button type="button" class="btn btn-lg btn-pos-dark pay-btn">
                        Pay
                    </button>  -->
                    <!-- <VSpacer/> -->
                    <v-btn rounded color="primary" @click="checkout">Pay
                        <v-icon right dark small>save</v-icon>
                    </v-btn>
                    <div>
                        <small style="color: red" v-if="errors.client_id">{{ errors.client_id[0] }}</small>
                    </div>
                    <v-btn block color="secondary">Hold</v-btn>
                </div>
            </div>
            <div>
                <div class="pos-modal-overlay"></div>
                <!---->
            </div>
            <div>
                <div class="pos-modal-overlay"></div>
                <!---->
            </div>
            <div>
                <div class="pos-modal-overlay"></div>
                <!---->
            </div>
        </div>
    </div>
    <!-- <VCardActions>
        <VBtn color="primary" text>Sell</VBtn>
        <VSpacer />
        <VBtn color="primary" text @click="reset">Clear</VBtn>
    </VCardActions> -->
</VCard>
</template>

<script>
export default {
    data() {
        return {
            product: null,
            customer_name: null,
            form: {
                discount_type: 'Fixed',
                discount: 0,
            },
            cart_item: {
                cart: []
            },
            options: [{
                value: 'Fixed',
                label: 'Fixed'
            }, {
                value: 'Percentage',
                label: 'Percentage'
            }],
        }
    },
    created() {
        eventBus.$on('addCartEvent', data => {
            console.log(data);

            this.product = data
            // data.product.sku_no = data.sku_no
            // data.product.sku_id = data.sku_id
            this.addCart(data)
        })
        eventBus.$on('addCartVariantEvent', res_data => {
            var choices = res_data.choices
            var data = res_data.skus
            this.product = data.product

            // console.log(data);

            if (this.cart_item.cart.length > 0) {
                this.cart_item.cart.forEach(element => {
                    if (data.sku_no == element.sku_no) {
                        data.product = element
                    }
                });
            }
            data.product.sku_no = data.sku_no
            data.product.price = data.price
            data.product.quantity = data.quantity
            data.product.sku_id = data.sku_id

            if (choices) {
                data.product.choices = choices
            }

            this.addCart(data.product)
        })

        eventBus.$on("selectClient", data => {
            this.cart_item.client_id = data.id
            this.customer_name = data.name
        });
    },
    methods: {
        addCart(product) {
            console.log(product);
            var exists = this.cart_item.cart.some(function (product_1) {
                return product_1.sku_no === product.sku_no
            });

            if (!exists) {
                product.ordered = 1
                this.cart_item.cart.push(product)
            } else {
                var index = this.cart_item.cart.indexOf(product);
                // console.log(index);

                var add_item = this.cart_item.cart[index];
                // console.log(add_item);

                add_item.ordered += 1
                Vue.set(this.cart_item.cart, index, add_item)
            }
        },
        reset() {
            this.cart_item.cart = []
        },
        remove(index) {
            this.cart_item.cart.splice(index, 1)
        },
        reduce(product, index) {
            var index = this.cart_item.cart.indexOf(product);
            var add_item = (Object.assign({}, product));
            add_item.ordered -= 1
            Vue.set(this.cart_item.cart, index, add_item)
            if (add_item.ordered == 0) {
                this.cart_item.cart.splice(index, 1)
                return
            }
            // console.log(add_item);
            Object.assign(this.cart_item.cart[index], add_item)
        },
        handleChange() {

        },
        openDiscount() {

        },
        openClient() {
            eventBus.$emit('openPageEvent', 'customer')
        },
        change_value(data) {
            console.log(data);

        },
        checkout() {
            this.cart_item.total_price = this.getTotal
            this.cart_item.discount = this.discount
            this.cart_item.sub_total_price = this.getSubTotal
            // console.log(this.cart_item.cart);

            // this.cart_item.cart.discount = this.discount
            var payload = {
                model: 'sales',
                data: this.cart_item,
            }
            this.$store.dispatch('postItems', payload)
        },
        getClient(query) {
            if (query.length > 2) {
                this.loading = true;
                this.form.search = query
                axios.get(`searchClient/${query}`).then((response) => {
                    this.loading = false
                    this.clients = response.data

                }).catch((error) => {
                    this.loading = true;
                })
            }
        },
    },
    computed: {
        getSubTotal() {
            var total = 0

            this.cart_item.cart.forEach(element => {
                total += element.price * element.ordered
            });
            this.cart_item.cart['sub_total_price'] = total
            return total
        },
        discount() {
            if (this.form.discount_type == 'Fixed') {
                return this.form.discount
            } else if (this.form.discount_type == 'Percentage') {
                return this.getSubTotal * (this.form.discount / 100)
            }
        },
        getTotal() {
            this.cart_item.cart['total_price'] = this.getSubTotal - this.discount
            return (this.getSubTotal - this.discount)
        },
        discounts() {
            return this.$store.getters.discounts
        },

        errors() {
            return this.$store.getters.errors

        },
        loading() {
            return this.$store.getters.loading

        },
        clients() {
            return this.$store.getters.clients

        },

    },
}
</script>

<style scoped>
div.pos-cart-container {
    /* width: 30%; */
    height: 580px;
    float: right;
    background: #FFFFFF;
    -webkit-box-shadow: 1px 2px 10px 0 rgba(0, 0, 0, 0.15);
    box-shadow: 1px 2px 10px 0 rgba(0, 0, 0, 0.15);
}

div.pos-cart-container .pos-content .cart .cart_details {
    list-style-type: none;
}

ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

div.pos-cart-container .pos-content .cart .cart_details div {
    display: inline-block;
    width: 100%;
}

div.pos-cart-container .pos-content .cart .cart_details div li {
    width: 100%;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    padding: 0px 10px;
    border-bottom: 1px solid #E0E0E0;
    cursor: pointer;
    min-height: 60px;
}

div.pos-cart-container .pos-content .cart .cart-header {
    font-size: 16px;
    padding: 0px 3px;
    height: 45px;
    border-bottom: 1px solid #E0E0E0;
    -webkit-box-shadow: 1px 0px 1px #E0E0E0;
    box-shadow: 1px 0px 1px #E0E0E0;
    display: inline-block;
    width: 100%;
}

div.pos-cart-container .pos-content .cart .cart-header .cart-hold-section {
    width: 38%;
    display: inline-block;
}

div.pos-cart-container .pos-content .cart .cart-header .cart-count-section {
    width: 60%;
    padding: 0px;
    display: inline-block;
    text-align: right;
    height: 100%;
}


li {
    background: #f9f9f9;
}

li:nth-child(odd) {
    background: #fceff3;
}

#choice_details li {
    background: transparent !important;
}


.pos-table-responsive .pos-table tbody>tr #select_discount input {
    width: 100% !important;
    padding: 0px !important;
    border: 1px solid #f0f0f0 !important;
    border-radius: 0px !important;
    /* font-size: 16px !important; */
    /* color: #333333 !important; */
    text-align: none !important;
}
</style>
