<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Product</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <div>
                                <label for="">Product name</label>
                                <el-input placeholder="Product name" v-model="form.product_name"></el-input>
                            </div>

                            <!-- <el-select v-model="form.option_" clearable placeholder="Supplier" style="width: 100%;"  @change="select_option_value">
                                <el-option v-for="item in option_values_n" :key="item.id" :label="item.option_name" :value="item.id">
                                </el-option>
                            </el-select>

                            <el-select v-model="form.option_val" clearable placeholder="Supplier" style="width: 100%;">
                                <el-option v-for="item in option_values_n_n.option_values" :key="item.id" :label="item.option_name" :value="item.id">
                                </el-option>
                            </el-select> -->

                            <v-layout wrap row>
                                <v-flex sm4 v-for="option in option_values_n" :key="option.id">
                                    {{ option.option_name }}

                                    <div v-for="option_value in option.option_values" :key="option_value.id">
                                        {{ option_value.option_name }}
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <!-- <v-btn text color="primary" @click="select_option_value"> optiom</v-btn> -->
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
        form: {},
        option_values_n: [],
        option_values_n_n: [],
    }),
    created() {
        eventBus.$on("openShowProduct", data => {
            this.dialog = true;
            this.form = data

            this.option_values_n = []
            data.product_options.forEach(element_1 => {
                this.option_values_n.push(element_1.option)
                console.log(element_1.option);
            });

        });
    },

    methods: {
        close() {
            this.dialog = false;
        },
        select_option_value() {
            this.option_values_n_n = []
            this.option_values_n.forEach(element => {
                    if (element.id == this.form.option_) {
                    console.log(element.option_values);
                       this.option_values_n_n.push(element)
                    }
            });
             this.option_values_n_n =  this.option_values_n_n[0]
        }
    },
    computed: {
        // prod() {
        //     return this.$store.dispatch('prod')
        // }
    },
};
</script>
