<template>
<div>
    <h5 class="text-center" style="color: #2bbdb9;">DISCOUNT TYPE</h5>
    <v-divider></v-divider>
    <div>
        <label for="">Discount type</label>
        <el-select v-model="form.discount_type" placeholder="Select" style="width:100%">
            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
            </el-option>
        </el-select>

        <v-radio-group v-model="form.product_type" v-if="form.discount_type == 'product_type'">
            <v-radio v-for="n in product_type" :key="n.value" :label="n.value" :value="n.value"></v-radio>
        </v-radio-group>
        <v-radio-group v-model="form.brand" v-if="form.discount_type == 'brand'">
            <v-radio v-for="n in brand" :key="n.value" :label="n.value" :value="n.value"></v-radio>
        </v-radio-group>
        <v-radio-group v-model="form.product" v-if="form.discount_type == 'product'">
            <v-radio v-for="n in product" :key="n.value" :label="n.value" :value="n.value"></v-radio>
        </v-radio-group>
        <v-radio-group v-model="form.order_value" v-if="form.discount_type == 'order_value'">
            <v-radio v-for="n in order_value" :key="n.value" :label="n.value" :value="n.value"></v-radio>
        </v-radio-group>

        <!-- Product type Start -->
        <div v-if="form.product_type == '% discount on items in one or more product types'">
            Get <span>
                <el-input placeholder="10%" v-model="form.discount_value"></el-input> off each item in the following product types:
            </span>

            <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                </el-option>
            </el-select>
            <br>
            <h6>Discount Type</h6>

            <el-radio v-model="form.discount_unit" label="percentage">Percentage</el-radio>
            <el-radio v-model="form.discount_unit" label="fixed">Fixed</el-radio>
        </div>

        <div v-if="form.product_type == 'Buy X quantity and get Y more units of the same product type for free'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> of
                <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            Get <span>
                <el-input placeholder="Please input" v-model="form.get_quantity"></el-input>
                unit/s of the same product type/s for free
            </span>
        </div>

        <div v-if="form.product_type == 'Buy X or more units to receive Y% off on all units of the same product type'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> or more of
                <!-- <el-input placeholder="Please input" v-model="form.get_quantity"></el-input> -->

                <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:60%; margin-top: 10px;">
                    <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            Get <span>
                <el-input placeholder="Please input" v-model="form.percentage_discount"></el-input>
                off every item in the selected product type/s
            </span>
        </div>

        <div v-if="form.product_type == 'Create a bargain bin to sell all items of a product type at one set discounted price.'">
            Buy any item from this bin @ <span>
                <el-input placeholder="KES 0.0" v-model="form.fixed_price"></el-input> of
            </span>
            <br>
            <br>
            <label for="">Bin price will apply to all items with product type/s selected here</label>
            <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                </el-option>
            </el-select>
        </div>

        <div v-if="form.product_type == 'Buy X units of product type A and get Z% off on Y units of product type B'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> of
                <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            Get <span>
                <el-input placeholder="Please input" v-model="form.percentage_discount"></el-input>
                off on up to
                <el-input placeholder="Please input" v-model="form.get_quantity"></el-input>
                units of product type
            </span>
            <br><br>
            <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                </el-option>
            </el-select>
            <br>
            <br>
            <ul>
                <li>Mix & match is allowed if more than one item is selected.</li>
                <li>Minimum specified quantity must be met.</li>
            </ul>
        </div>

        <div v-if="form.product_type == 'Buy X units of Product A and get Y units of Product B for free'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> of
                <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            and get <span>
                <el-input placeholder="Please input" v-model="form.percentage_discount"></el-input>
                unit/s of
                <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                    </el-option>
                </el-select>
            </span>
        </div>
        <!-- Product type End -->

        <!-- Brand Start -->
        <div v-if="form.product_type == 'Offer a set % discount on selected brand/s'">
            Get <span>
                <el-input placeholder="KES 0.0" v-model="form.percentage_discount"></el-input> off on all items selected below:
            </span>

            <el-select multiple collapse-tags v-model="form.brand" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item.id">
                </el-option>
            </el-select>
        </div>

        <div v-if="form.product_type == 'Buy X quantity and get Y more units of the same brand for free'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> of
                <el-select multiple collapse-tags v-model="form.brand" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            Get <span>
                <el-input placeholder="Please input" v-model="form.get_quantity"></el-input>
                Unit/s from the same brand/s for free
            </span>
        </div>

        <div v-if="form.product_type == 'Buy X or more units to receive Y% off on all units of the brand'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> or more of
                <!-- <el-input placeholder="Please input" v-model="form.get_quantity"></el-input> -->

                <el-select multiple collapse-tags v-model="form.brand" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            Get <span>
                <el-input placeholder="Please input" v-model="form.percentage_discount"></el-input>
                off every item in the selected product type/s
            </span>
        </div>

        <div v-if="form.product_type == 'Create a bargain bin to sell an unsorted selection of a brand at one set price.'">
            Buy any item from this bin @ <span>
                <el-input placeholder="KES 0.0" v-model="form.fixed_price"></el-input> of
            </span>
            <br>
            <br>
            <label for="">Bin price will apply to all items with product type/s selected here</label>
            <el-select multiple collapse-tags v-model="form.brand" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item.id">
                </el-option>
            </el-select>
        </div>

        <div v-if="form.product_type == 'Buy X units of Brand A and get Z% off on Y units of brand B'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> of
                <el-select multiple collapse-tags v-model="form.brand" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            Get <span>
                <el-input placeholder="Please input" v-model="form.percentage_discount"></el-input>
                off on up to
                <el-input placeholder="Please input" v-model="form.get_quantity"></el-input>
                units of product type
            </span>
            <br><br>
            <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                </el-option>
            </el-select>
            <br>
            <br>
            <ul>
                <li>Mix & match is allowed if more than one item is selected.</li>
                <li>Minimum specified quantity must be met.</li>
            </ul>
        </div>

        <div v-if="form.product_type == 'Buy X units of brand A and get Y units of brand B for free'">
            Buy <span>
                <el-input placeholder="QTY" v-model="form.buy_quantity"></el-input> of
                <el-select multiple collapse-tags v-model="form.brand" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item.id">
                    </el-option>
                </el-select>
            </span>
            <br>
            <br>
            and get <span>
                <el-input placeholder="Please input" v-model="form.percentage_discount"></el-input>
                unit/s of
                <el-select multiple collapse-tags v-model="form.category" placeholder="Select product type" style="width:100%; margin-top: 10px;">
                    <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item.id">
                    </el-option>
                </el-select>
            </span>
        </div>
        <!-- Brand End -->
    </div>
</div>
</template>

<script>
export default {
    props: ['form'],
    data() {
        return {
            options: [{
                value: 'product_type',
                label: 'Product type'
            }, {
                value: 'brand',
                label: 'Brand'
            }, {
                value: 'product',
                label: 'Product'
            }, {
                value: 'Order value',
                label: 'order_value'
            }],

            product_type: [{
                value: '% discount on items in one or more product types'
            }, {
                value: 'Buy X quantity and get Y more units of the same product type for free'
            }, {
                value: 'Buy X or more units to receive Y% off on all units of the same product type'
            }, {
                value: 'Create a bargain bin to sell all items of a product type at one set discounted price.'
            }, {
                value: 'Buy X units of product type A and get Z% off on Y units of product type B'
            }, {
                value: 'Buy X units of Product A and get Y units of Product B for free'
            }],

            brand: [{
                value: 'Offer a set % discount on selected brand/s'
            }, {
                value: 'Buy X quantity and get Y more units of the same brand for free'
            }, {
                value: 'Buy X or more units to receive Y% off on all units of the brand'
            }, {
                value: 'Create a bargain bin to sell all items of a product type at one set discounted price.'
            }, {
                value: 'Create a bargain bin to sell an unsorted selection of a brand at one set price.'
            }, {
                value: 'Buy X units of Brand A and get Z% off on Y units of brand B'
            }, {
                value: 'Buy X units of brand A and get Y units of brand B for free'
            }],
            product: [{
                value: 'Offer a set % discount on selected product/s.'
            }, {
                value: 'Buy X quantity and get Y more units of the same product for free'
            }, {
                value: 'Buy X or more units to receive Y% off on all units'
            }, {
                value: 'Create a new composite product using existing items as components'
            }, {
                value: 'Create a bargain bin to sell an unsorted selection of items at one set price.'
            }, {
                value: 'Buy X units of product A and get Z% off on Y units of product B'
            }, {
                value: 'Buy X units of Product A and get Y units of Product B for free'
            }, {
                value: 'Buy X units of product A and get $Y off (Set $ amount off, not %)'
            }],
            order_value: [{
                value: 'Apply X % discount if total order value is more than Y amount'
            }]

        }
    },
    methods: {
        getProduct(search) {
            // console.log(search);
            if (search.length > 2) {
                var payload = {
                    model: 'product_search',
                    update_: 'updateProductsList',
                    search: search
                }
                this.$store.dispatch("searchItems", payload);
            }
        },

    },

    computed: {
        categories() {
            return this.$store.getters.categories
        },
        brands() {
            return this.$store.getters.brands
        },
        loading() {
            return this.$store.getters.loading
        },
        products() {
            return this.$store.getters.products
        }
    },
}
</script>

<style scoped>
label {
    color: #5d5252 !important;
}

.el-input {
    width: 20%;
}
</style>
