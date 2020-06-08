<template>
<div>
    <h3 class="text-center">PRIMARY INFORMATION</h3>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex xs12 sm8>
            <v-layout wrap>
                <v-flex xs12 sm12 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Product name*</label>
                    <el-input placeholder="Product name*" v-model="product.product_name"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">SKU</label>
                    <el-input placeholder="SKU" min="0" v-model="product.sku_no"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Barcode</label>
                    <el-input placeholder="Barcode" v-model="product.bar_code"></el-input>
                </v-flex>
                <v-flex xs4 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Length(in)</label>
                    <el-input placeholder="Length(in)" min="0" type="number" v-model="product.length"></el-input>
                </v-flex>
                <v-flex xs4 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Width(in)</label>
                    <el-input placeholder="Width(in)" min="0" type="number" v-model="product.width"></el-input>
                </v-flex>
                <v-flex xs4 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Height(in)</label>
                    <el-input placeholder="Height(in)" min="0" type="number" v-model="product.height"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Weight({{ product.measure }})</label>
                    <el-input placeholder="Weight" min="0" type="number" v-model="product.weight"></el-input>
                    <el-select v-model="product.measure" clearable placeholder="Select Measure" style="margin-top: 10px">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                        </el-option>
                    </el-select>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex xs12 sm3 offset-sm1>
            <v-card :color="color">
                <v-card-title>
                    Heads up!
                </v-card-title>
                <v-card-text>
                    <p>Tell us about your product. The unique barcode will help us scan and identify the product.</p>
                    <br>
                    <p>Once you set the re-order point, we will notify you when the on-hand level matches the re-order point, so you can send us more inventory!</p>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex xs12 sm12 style="padding: 7px 0;">
            <label for="">Description</label>
            <vue-editor v-model="product.description"></vue-editor>
            <div v-if="errors.product">
            <small class="text-danger" v-if="errors.product.description">{{ errors.product.description[0] }}</small>
            </div>

        </v-flex>
    </v-layout>
</div>
</template>

<script>
import {
    VueEditor
} from "vue2-editor";

export default {
    components: {
        VueEditor
    },
    props: ['product'],
    data() {
        return {
            color: '#f4f6f8',
            options: [{
                value: 'Kgs',
                label: 'Kgs'
            }, {
                value: 'g',
                label: 'Grams'
            }, {
                value: 'Lbs',
                label: 'Pounds'
            }, ],
        }
    },
    mounted() {
        // this.$store.dispatch('getCountries');
    },
    computed: {
        countries() {
            return this.$store.getters.countries
        },

        errors() {
            return this.$store.getters.errors
        },

    },
}
</script>
