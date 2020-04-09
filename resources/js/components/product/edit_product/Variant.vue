<template>
<div>
    <v-layout row wrap>
        <v-flex sm12>
            <v-checkbox v-model="product.has_varients" label="This product has multiple variants"></v-checkbox>
        </v-flex>
        <v-flex sm12 v-if="product.has_varients">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">VARIANT OPTION</th>
                        <th scope="col">OPTION VALUES</th>
                        <!-- <th scope="col">ACTION</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(variants_a, index) in form.variants_d" :key="index">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>
                            <el-select v-model="variants_a.variants" filterable placeholder="e.g.Size" @input="change_subvariants(variants_a.variants)">
                                <el-option v-for="item in variants" :key="item.id" :label="item.title" :value="item.id">
                                </el-option>
                            </el-select>
                        </td>
                        <td>
                            <el-select v-model="variants_a.subvariants" filterable placeholder="" multiple>
                                <el-option v-for="item in subvariants" :key="item.id" :label="item.title" :value="item.id">
                                </el-option>
                            </el-select>
                        </td>
                        <!-- <td>
                            <v-tooltip bottom>
                                <v-btn icon class="mx-0" slot="activator" @click="remove(index)">
                                    <v-icon small color="pink darken-2">delete</v-icon>
                                </v-btn>
                                <span>Remove</span>
                            </v-tooltip>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </v-flex>
        <v-flex sm12>
            <v-btn color="info" raised @click="addNew">Add another option</v-btn>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    props: ['product', 'form'],
    data: () => ({
        subvariants: [],

    }),

    methods: {
        addNew() {
            this.form.variants_d.push({
                variant: '',
                options: {},
                options: {},
            })
        },
        variant_done() {

        },
        getVariants() {
            this.$store.dispatch('getVariants')
        },
        edit(index, item) {
            if (!this.editing) {
                this.editing = item
                this.index = index
            } else {
                this.editing = null
                this.index = -1
            }
        },
        filter(item, queryText, itemText) {
            if (item.header) return false
            const hasValue = val => val != null ? val : ''
            const text = hasValue(itemText)
            const query = hasValue(queryText)
            return text.toString()
                .toLowerCase()
                .indexOf(query.toString().toLowerCase()) > -1
        },
        change_subvariants(data) {
            this.subvariants = []
            console.log(data);
            axios.get(`subvariant/${data}`)
                .then((response) => {
                    this.subvariants = response.data
                })
        },
        remove(index) {
            this.form.variants_d.splice(index, 1);
        }
    },

    computed: {
        variants() {
            return this.$store.getters.variants
        },
    },

    mounted() {
        this.getVariants();
    },
}
</script>

<style scoped>
.v-autocomplete__content.v-menu__content,
.v-autocomplete__content.v-menu__content .v-card {
    border-radius: 0;
    display: none !important;
}
</style>
