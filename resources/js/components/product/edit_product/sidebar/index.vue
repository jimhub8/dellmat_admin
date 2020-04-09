<template>
<div>
    <h3 class="text-center"><strong>Categorize</strong></h3>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex xs12 style="padding: 7px 10px 20px 10px;">
            <label for="" style="color: #52627d;">Product types</label>
            <el-select v-model="product.categories" multiple filterable clearable placeholder="Select Categories" style="width:100%;" value-key="id">
                <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item">
                </el-option>
            </el-select>
        </v-flex>
    </v-layout>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex xs12 style="padding: 7px 10px 20px 10px;">
            <label for="" style="color: #52627d;">Sub Categories</label>
            <el-select v-model="product.subcategories" multiple filterable clearable placeholder="Select Categories" style="width:100%;" value-key="id">
                <el-option v-for="item in subcategories.data" :key="item.id" :label="item.subcategory" :value="item">
                </el-option>
            </el-select>
        </v-flex>
    </v-layout>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex xs12 style="padding: 7px 10px 20px 10px;">
            <label for="" style="color: #52627d;">Product Brands</label>
            <el-select v-model="product.brands" multiple filterable clearable placeholder="Select Brands" style="width:100%;" value-key="id">
                <el-option v-for="item in brands.data" :key="item.id" :label="item.brand" :value="item">
                </el-option>
            </el-select>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    name: 'category_brand',
    components: {},
    props: ['product'],
    data() {
        return {
            color: '#f4f6f8',
        }
    },
    methods: {
        getCategories() {

            var payload = {
                model: 'categories',
                update_list: 'updateCategoryList'
            }
            this.$store.dispatch("getItems", payload);
        },
        getSubcategories() {

            var payload = {
                model: 'subcategories',
                update_list: 'updateSubcategoryList'
            }
            this.$store.dispatch("getItems", payload);
        },
        getbrands() {

            var payload = {
                model: 'brands',
                update_list: 'updateBrandList'
            }
            this.$store.dispatch("getItems", payload);
        },
    },
    mounted() {
        this.getCategories()
        this.getSubcategories()
        this.getbrands()
    },
    computed: {
        categories() {
            return this.$store.getters.categories;
        },
        subcategories() {
            return this.$store.getters.subcategories;
        },
        brands() {
            return this.$store.getters.brands;
        },
    },
}
</script>
