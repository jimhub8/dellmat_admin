<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Select variants</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm4 v-for="variant in variants" :key="variant.id">
                            {{ variant.attribute.option_name }}
                            <VDivider />
                            <!-- <div v-for="(variant_values, index) in variant.tags" :key="variant_values.id"> -->
                            <!-- {{ variant_values.option_name }} -->

                            <el-radio-group v-for="variant_values in variant.tags" :key="variant_values.id" v-model="variant.choise">
                                <el-radio-button :label="variant_values.option_name"></el-radio-button>
                            </el-radio-group>
                            <!-- </div> -->
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                <VSpacer/>
                <v-btn color="blue darken-1" text @click="getChoiseData">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        form: {

        },
        dialog: false,
        product: null,
        variants: {},
        variants_values: {},
    }),
    created() {
        eventBus.$on("selectVariantsEvent", data => {
            this.dialog = true;
            this.product = data
            this.getProductVariants(data.id)
        });
    },

    methods: {
        getProductVariants(id) {
            axios
                .get(`product_variant/${id}`)
                .then(response => {
                    // this.loading = false;
                    this.variants = response.data;
                })
                .catch(error => {
                    // this.loading = false;
                });
        },

        getChoiseData() {
            this.loading = true
            axios
                .post(`variants_values/${this.product.id}`, this.variants)
                .then(response => {
                    this.loading = false;
                    this.variants_values = response.data;
                    eventBus.$emit('addCartVariantEvent', response.data)
                })
                .catch(error => {
                    console.log(error);

                    this.loading = false;
                });
        },


        close() {
            this.dialog = false;
        }
    },
    computed: {},
};
</script>
