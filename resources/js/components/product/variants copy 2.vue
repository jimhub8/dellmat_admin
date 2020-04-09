<template>
<div>
    <el-dialog title="Sku Prefix" :visible.sync="dialog" width="30%">
        <el-input v-model="form.prefix" autocomplete="off"></el-input>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialog = false">Cancel</el-button>
            <el-button type="primary" @click="update">Submit</el-button>
        </span>
    </el-dialog>
    <el-dialog title="Price" :visible.sync="pricedialog" width="30%">
        <el-input v-model="form.price" autocomplete="off"></el-input>
        <span slot="footer" class="dialog-footer">
            <el-button @click="pricedialog = false">Cancel</el-button>
            <el-button type="primary" @click="update_price">Submit</el-button>
        </span>
    </el-dialog>
    <el-dialog title="Reorder Point" :visible.sync="reorderdialog" width="30%">
        <el-input v-model="form.reorder_point" autocomplete="off"></el-input>
        <span slot="footer" class="dialog-footer">
            <el-button @click="reorderdialog = false">Cancel</el-button>
            <el-button type="primary" @click="update_reorder">Submit</el-button>
        </span>
    </el-dialog>
    <el-dialog title="Reorder Point" :visible.sync="qtydialog" width="30%">
        <el-input v-model="form.qty_available" autocomplete="off"></el-input>
        <span slot="footer" class="dialog-footer">
            <el-button @click="qtydialog = false">Cancel</el-button>
            <el-button type="primary" @click="update_qty">Submit</el-button>
        </span>
    </el-dialog>
    <v-layout justify-center align-center>
        <v-card style="width: 100%">
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Items Group</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard style="width: 100%">
                            <v-flex sm12>
                                <v-card-text>
                                    <div>
                                        <label for="">Multiple Items?</label>
                                    </div>
                                    <VDivider />
                                    <div v-for="(attr, index) in attribute_arr" :key="index">
                                        <v-layout row wrap>
                                            <v-flex sm4>

                                                <!-- <div v-for="option in options" :key="option.id">
                                                    <VDivider />
                                                    {{ option.option_name }} <br />

                                                    <div v-for="option_value in option.option_values" :key="option_value.id">
                                                        <v-checkbox v-model="selected" label="John" value="John"></v-checkbox>

                                                        {{ option_value.option_name }}
                                                    </div>
                                                </div> -->

                                                <!-- <label for="">Attribute</label> <br> -->
                                                <v-select v-model="attr.attribute" :items="options" item-text="option_name" item-value="option_name" label="Options" persistent-hint return-object single-line @change="option_attr"></v-select>
                                                <!-- <div v-for="attr.attribute"></div> -->
                                                <!-- <el-select filterable v-model="attr.attribute" clearable placeholder="Attribute" @change="select_option_value">
                                                    <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                                                    </el-option>
                                                </el-select> -->
                                            </v-flex>
                                            <v-flex sm4 style="margin-left: 87px">
                                                <!-- <label for="">Options</label> -->
                                                <!-- <v-select v-model="attr.tags" multiple :items="option_values" item-text="option_name" item-value="id" label="Options" persistent-hint return-object single-line v-if="'option_id' == attr.attribute.id"></v-select> -->

                                                <el-select v-model="attr.tags" multiple collapse-tags style="margin-left: 20px;" placeholder="Select" value-key="id">
                                                    <el-option v-for="item in option_values" :key="item.id" :label="item.option_name" :value="item" v-if="item.option_id == attr.attribute.id">
                                                    </el-option>
                                                </el-select>
                                                <!-- <vue-tags-input v-model="attr.tag" :tags="attr.tags" @tags-changed="newTags => attr.tags = newTags" /> -->
                                            </v-flex>
                                            <v-flex sm2>

                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn icon v-on="on" class="mx-0" @click="remove(index)" slot="activator" style="margin-top: 30px !important">
                                                            <v-icon small color="pink darken-2">delete</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Remove</span>
                                                </v-tooltip>
                                            </v-flex>
                                        </v-layout>
                                    </div>
                                    <v-flex sm12>
                                        <v-btn raised color="info" @click="add_attribute" v-if="attribute_arr.length < 3">Add more attributes</v-btn>
                                    </v-flex>
                                </v-card-text>
                            </v-flex>

                            <v-flex sm12>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">ITEM NAME</th>
                                            <th scope="col">SKU
                                                <span>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn v-on="on" icon class="mx-0" @click="sku_generate" slot="activator">
                                                                <v-icon small color="pink darken-2">settings</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Generate sku</span>
                                                    </v-tooltip>
                                                </span>
                                            </th>
                                            <th scope="col">Price(KES)
                                                <span>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn v-on="on" icon class="mx-0" @click="copyPrice" slot="activator">
                                                                <v-icon small color="info darken-2">file_copy</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Update All</span>
                                                    </v-tooltip>
                                                </span>
                                            </th>
                                            <th scope="col">Quantity
                                                <span>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn v-on="on" icon class="mx-0" @click="copyQty" slot="activator">
                                                                <v-icon small color="blue darken-2">file_copy</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Update All</span>
                                                    </v-tooltip>
                                                </span>
                                            </th>
                                            <th scope="col">REORDER LEVEL
                                                <span>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn v-on="on" icon class="mx-0" @click="copyReorder" slot="activator">
                                                                <v-icon small color="blue darken-2">file_copy</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Update All</span>
                                                    </v-tooltip>
                                                </span>
                                            </th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in itemAttribute_arr" :key="index">
                                            <th scope="row">{{ index + 1 }}</th>
                                            <td>{{ item.item_name }}</td>
                                            <td>
                                                <el-input placeholder="Please input" v-model="item.sku_no" clearable>
                                                </el-input>
                                            </td>
                                            <td>
                                                <el-input placeholder="Please input" v-model="item.price" clearable type="number">
                                                </el-input>
                                            </td>
                                            <td>
                                                <el-input placeholder="Please input" v-model="item.qty_available" clearable type="number">
                                                </el-input>
                                            </td>
                                            <td>
                                                <el-input placeholder="Please input" v-model="item.reorder_point" clearable type="number">
                                                </el-input>
                                            </td>
                                            <td>
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn v-on="on" icon class="mx-0" @click="deleteItem(index)" slot="activator">
                                                            <v-icon small color="pink darken-2">delete</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Delete</span>
                                                </v-tooltip>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-flex>
                            <v-flex sm12>
                                <v-btn color="info" @click="summary">summary</v-btn>
                            </v-flex>
                        </VCard>
                    </v-layout>

                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="save" :loading="loading" :disabled="loading">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-layout>
</div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
export default {
    components: {
        VueTagsInput,
    },
    props: ['product', 'attributes_b', 'sku_details'],
    data() {
        return {
            qtydialog: false,
            errors: {},
            reorderdialog: false,
            dialog: false,
            loading: false,
            options_val: null,
            // options: [{
            //         value: 'Color',
            //         label: 'Color'
            //     },
            //     {
            //         value: 'Size',
            //         label: 'Size'
            //     },
            //     {
            //         value: 'Storage',
            //         label: 'Storage'
            //     },
            // ],
            options_2: [{
                    text: 'Red',
                    label: 'Red'
                },
                {
                    text: 'Blue',
                    label: 'Blue'
                },
                {
                    text: 'Green',
                    label: 'Green'
                },
            ],
            units: [{
                value: 'KGs',
                label: 'KGs'
            }, {
                value: 'Grams',
                label: 'Grams'
            }, {
                value: 'Pounds',
                label: 'Pounds'
            }, ],
            form: {
                prefix: 'SKU_',
                group_name: '',
                itemAttribute_arr: null
            },
            pricedialog: false,
            tag: '',
            attribute_arr: [],
            itemAttribute_arr: [],
            tags: [],
            attributeShow: '',
            u_id: null,
            variants: [],
            option_values_n_n: [],
            da: [],
        };
    },
    methods: {
        update() {
            this.dialog = false
            this.summary()
        },
        update_price() {
            this.itemAttribute_arr.forEach(element => {
                element.price = this.form.price
            });
            this.pricedialog = false
        },
        update_reorder() {
            this.itemAttribute_arr.forEach(element => {
                element.reorder_point = this.form.reorder_point
            });
            this.reorderdialog = false
        },

        update_qty() {
            this.itemAttribute_arr.forEach(element => {
                element.qty_available = this.form.qty_available
            });
            this.qtydialog = false
        },

        searchClient(search) {
            if (search.length > 2) {
                // this.$store.dispatch('searchClient', search)
                // }
                this.loading = true;
                // this.search_item.search = search
                // this.$store.dispatch('getProducts');
                axios.get(`searchClient/${search}`).then((response) => {
                    this.loading = false
                    // this.data = response.data
                    this.clients = response.data.filter(item => {
                        return item.name.toLowerCase()
                            .indexOf(search.toLowerCase()) > -1;
                    });
                }).catch((error) => {

                })
            }
        },
        save() {
            this.form.itemAttribute_arr = this.itemAttribute_arr
            this.errors = {}
            this.loading = true
            axios.post('/groups', this.$data.form).then((response) => {
                this.loading = false
                // console.log(response);
                this.$store.dispatch('alertEvent', 'Product added')
                // this.$store.dispatch('getProducts')
                eventBus.$emit('productEvent', data)
                this.close()
            }).catch((error) => {
                // console.log(error.response);
                this.loading = false
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    this.loading = false
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                }
                this.errors = error.response.data.errors
            })
        },
        close() {
            this.dialog = false;
        },
        deleteItem(index) {
            this.itemAttribute_arr.splice(index, 1)
        },
        remove(index) {
            this.attribute_arr.splice(index, 1)
        },
        sku_generate() {
            this.dialog = true
        },
        copyPrice() {
            this.pricedialog = true
        },
        copyReorder() {
            this.reorderdialog = true
        },
        copyQty() {
            this.qtydialog = true
        },
        summary() {
            this.variants = []
            this.itemAttribute_arr = []
            var i = 0
            if (this.attribute_arr.length < 1) {
                eventBus.$emit('errorEvent', 'select an attribute')
            }
            if (this.attribute_arr.length == 1) {
                for (let index = 0; index < this.attribute_arr.length; index++) {
                    const element = this.attribute_arr[index];
                    for (let key = 0; key < element.tags.length; key++) {
                        i++
                        const element_a = element.tags[key];
                        this.itemAttribute_arr.push({
                            item_name: this.product.product_name + '/' + element_a.option_name,
                            sku_no: this.form.prefix + ("00000000" + (parseInt(this.unique_sku) + i)).slice(-8),
                            price: 0,
                            reorder_point: 0,
                            qty_available: 0,
                        })
                    }
                }
            } else if (this.attribute_arr.length == 2) {
                for (let index = 0; index < this.attribute_arr.length; index++) {
                    const element = this.attribute_arr[index];
                    // console.log(element);
                    for (let index_1 = 1; index_1 < this.attribute_arr.length; index_1++) {
                        const element_1 = this.attribute_arr[index_1];
                        // console.log(element_1);
                        for (let key = 0; key < element.tags.length; key++) {
                            const element_a = element.tags[key];
                            // var sku_ = this.form.prefix + ("00000000" + (parseInt(this.unique_sku) + i)).slice(-8)
                            // console.log(sku_);
                            for (let key_1 = 0; key_1 < element_1.tags.length; key_1++) {
                                const element_b = element_1.tags[key_1];
                                if (element_a.option_name != element_b.option_name && element_a.option_name != '' && element_b.option_name != '' && element != element_1) {
                                    i++
                                    // console.log(element_a.option_name + element_b.option_name);
                                    this.itemAttribute_arr.push({
                                        item_name: this.product.product_name + '-' + element_b.option_name + '/' + element_a.option_name,
                                        sku_no: this.form.prefix + ("00000000" + (parseInt(this.unique_sku) + i)).slice(-8),
                                        price: 0,
                                        reorder_point: 0,
                                        qty_available: 0,
                                    })
                                }
                            }
                        }
                    }
                }
            } else if (this.attribute_arr.length == 3) {
                for (let index = 0; index < this.attribute_arr.length; index++) {
                    const element = this.attribute_arr[index];
                    // console.log(element);
                    for (let index_1 = 1; index_1 < this.attribute_arr.length; index_1++) {
                        const element_1 = this.attribute_arr[index_1];
                        for (let index_2 = 2; index_2 < this.attribute_arr.length; index_2++) {
                            const element_2 = this.attribute_arr[index_2];
                            // console.log(element_1);
                            for (let key = 0; key < element.tags.length; key++) {
                                const element_a = element.tags[key];
                                // console.log(element_a);
                                for (let key_1 = 0; key_1 < element_1.tags.length; key_1++) {
                                    const element_b = element_1.tags[key_1];
                                    for (let key_2 = 0; key_2 < element_2.tags.length; key_2++) {
                                        const element_c = element_2.tags[key_2];
                                        if (element_a.option_name != element_b.option_name && element_a.option_name != '' && element_b.option_name != '' && element != element_1 && element_a.option_name != element_c.option_name && element_a.option_name != '' && element_c.option_name != '' && element != element_2 &&
                                            element_b.option_name != element_c.option_name && element_b.option_name != '' && element_c.option_name != '' && element_1 != element_2) {
                                            i++

                                            // console.log(element_a.option_name + element_b.option_name);
                                            var sku_no = this.product.product_name.substring(0, 2) + '_' + element_b.option_name.substring(0, 2) + '_' + element_a.option_name.substring(0, 2) + '_' + element_c.option_name.substring(0, 2)
                                            // var sku_no = null
                                            // console.log(sku_no);
                                            if (this.sku_details.length > 0) {
                                            var sku_no = sku_no + ("_00000000" + ((this.unique_sku) + i)).slice(-8)
                                                this.sku_details.forEach(element_sku => {
                                                    console.log(sku_no, '               ', element_sku.sku_no);
                                                    if (sku_no == element_sku.sku_no) {
                                                        this.itemAttribute_arr.push({
                                                            item_name: this.product.product_name + '-' + element_b.option_name + '/' + element_a.option_name + '/' + element_c.option_name,
                                                            sku_no: sku_no,
                                                            price: element_sku.price,
                                                            reorder_point: element_sku.reorder_point,
                                                            qty_available: element_sku.quantity,
                                                        })

                                                        sku_no = ''
                                                    }

                                                });
                                            } else {
                                            console.log(sku_no);
                                                sku_no = sku_no + ("_00000000" + ((this.unique_sku) + i)).slice(-8)
                                            console.log(sku_no);
                                                this.itemAttribute_arr.push({
                                                    item_name: this.product.product_name + '-' + element_b.option_name + '/' + element_a.option_name + '/' + element_c.option_name,
                                                    sku_no: sku_no,
                                                    price: 0,
                                                    reorder_point: 0,
                                                    qty_available: 0,
                                                })
                                                sku_no = ''

                                            }

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            this.variants.push(this.attribute_arr)
            this.variants.push(this.itemAttribute_arr)

            eventBus.$emit('variantEvent', this.variants)
            // this.products.variants = this.$data.form

        },
        add_attribute() {
            this.attribute_arr.push({
                attribute: '',
                tag: '',
                tags: [],
            })
        },

        getOptions() {
            var payload = {
                model: 'options',
                update_list: 'updateOptionsList',
            }
            this.$store.dispatch("getItems", payload);

        },
        getOptionV() {
            var payload = {
                model: 'option_values',
                update_list: 'updateOptionValuesList',
            }
            this.$store.dispatch("getItems", payload);

        },
        getUniqueSku() {
            var payload = {
                model: 'unique_sku',
                update_list: 'updateunique_sku',
            }
            this.$store.dispatch("getItems", payload);

        },
        select_option_value() {
            this.option_values_n_n = []
            this.options.forEach(element => {
                if (element.id == attr.attribute) {
                    console.log(element.option_values);
                    this.option_values_n_n.push(element)
                }
            });
            this.option_values_n_n = this.option_values_n_n[0]
        },

        option_attr(item) {
            console.log(item);
        },
        load_attributes() {
            this.attribute_arr = this.attributes_b;
            this.summary();
        },
    },
    computed: {
        unique_sku() {
            return this.$store.getters.unique_sku
        },

        options() {
            return this.$store.getters.options
        },
        option_values() {
            return this.$store.getters.option_values
        },

    },
    mounted() {
        this.$store.dispatch('getunique_sku')
        this.getOptions()
        this.getOptionV()
        this.getUniqueSku()
        setTimeout(() => {
            this.load_attributes()

        }, 2000);
        // setInterval(() => {
        // }, 3000);
    },
    created() {
        eventBus.$on('load_attributes', data => {
            // this.load_attributes()
            // this.getOptions()
        });
    },
}
</script>

<style>

</style>
