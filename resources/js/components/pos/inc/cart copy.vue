<template>
<VCard>
    <ul class="list-group">
        <li class="list-group-item active">Cart Details</li>
        <li class="list-group-item" v-for="(item, index) in cart" :key="item.id">
            <label for="">{{ item.name }}</label>
            <v-btn icon class="mx-0" style="float: right" @click="remove(index)">
                <v-icon color="error darken-2" small>close</v-icon>
            </v-btn>
            <br>
            <v-btn icon class="mx-0" @click="reduce(item, index)">
                <!-- <v-icon color="primary darken-2" small>-</v-icon> -->
                <i class="fa fa-minus"></i>
            </v-btn>
            <VBtn color="primary" text>{{ item.ordered }} units</VBtn>
            <v-btn icon class="mx-0" @click="addCart(item)">
                <v-icon color="primary darken-2" small>add</v-icon>
            </v-btn>
            <br>
            <!-- <p>{{ item.ordered }} units</p> -->
            <b style="float: right;color: rgb(219, 50, 77);">{{ item.ordered * item.price }}</b>
        </li>
        <li class="list-group-item">
            <b>Sub Total</b>
            <b style="float: right">KES{{ getSubTotal }}</b>
            <el-select v-model="form.discount_type" placeholder="Select">
                <el-option v-for="item in options" clearable :key="item.value" :label="item.label" :value="item.value">
                </el-option>
            </el-select>
            <el-input-number v-model="form.discount" @change="handleChange" :min="0"></el-input-number>
        </li>
        <li class="list-group-item">
            <b>Tax Total</b>
            <b style="float: right">KES 0</b>
        </li>
        <li class="list-group-item">
            <b>Grand Total</b>
            <b style="float: right">KES{{ getTotal }}</b>
        </li>
    </ul>
    <VCardActions>
        <VBtn color="primary" text>Sell</VBtn>
        <VSpacer />
        <VBtn color="primary" text @click="reset">Clear</VBtn>
    </VCardActions>
</VCard>
</template>

<script>
export default {
    // props: ['cart'],
    data() {
        return {
            product: null,
            form: {
                discount_type: 'Fixed',
                discount: 0,
            },
            cart: [],
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
            this.product = data
            this.addCart(data)
        })
    },
    methods: {
        addCart(product) {
            // var product = this.product
            var exists = this.cart.some(function (product_1) {
                return product_1.id === product.id
            });
            if (!exists) {
                product.ordered = 1
                this.cart.push(product)
            } else {
                var index = this.cart.indexOf(product);
                var add_item = (Object.assign({}, product));
                add_item.ordered += 1
                // console.log(add_item);
                // Object.assign(this.$parent.AllCharges[this.$parent.editedIndex], this.$parent.editCharge)
                this.cart.splice(index, 1, add_item)
                // Object.assign(this.cart[index], add_item)
            }
            // this.cart = this.cart
        },
        reset() {
            this.cart = []
        },
        remove(index) {
            this.cart.splice(index, 1)
        },
        reduce(product, index) {
            var index = this.cart.indexOf(product);
            var add_item = (Object.assign({}, product));
            add_item.ordered -= 1
            if (add_item.ordered == 0) {
                this.cart.splice(index, 1)
                return
            }
            // console.log(add_item);
            Object.assign(this.cart[index], add_item)
        },
        handleChange() {

        },
    },
    computed: {
        getSubTotal() {
            var total = 0
            this.cart.forEach(element => {
                total += element.price * element.ordered
            });
            return total
        },
        discount() {
            if (this.form.discount_type == 'Fixed') {
                return this.form.discount
            } else if(this.form.discount_type == 'Percentage') {
                return this.getSubTotal * (this.form.discount / 100)
            }
        },
        getTotal() {
            return (this.getSubTotal - this.discount)
        },
    },
}
</script>
