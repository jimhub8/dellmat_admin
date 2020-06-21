<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Subcategory</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs12 style="padding: 7px 10px 20px 10px;">
                            <label for="" style="color: #52627d;">Category</label>
                            <el-select v-model="form.categories" filterable clearable placeholder="Select categories" style="width:100%;" value-key="id">
                                <el-option v-for="item in categories.data" :key="item.id" :label="item.category" :value="item">
                                </el-option>
                            </el-select>
                        </v-flex>
                        <v-flex sm12>
                            <v-card-text>
                                <div>
                                    <label for="">Subcategory</label>
                                    <el-input placeholder="Tops..." v-model="form.subcategory"></el-input>
                                </div>
                            </v-card-text>
                        </v-flex>
                        <v-flex sm12>
                            <label for="">Description</label>
                            <el-input type="textarea" placeholder="Please input" v-model="form.description">
                            </el-input>
                            </div>
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
        form: {},
        errors: {},
        payload: {
            model: 'subcategories',
        },
    }),
    created() {
        eventBus.$on("openCreateSubcategory", data => {
            this.dialog = true;
            this.getCategories()
        });
    },

    methods: {
        save() {
            this.payload['data'] = this.form
            this.$store.dispatch('postItems', this.payload)
                .then(response => {
                    eventBus.$emit("subcategoryEvent")
                });
        },
        close() {
            this.dialog = false;
        },

        getCategories() {
            var payload = {
                model: 'categories',
                update_list: 'updateCategoryList'
            }
            this.$store.dispatch("getItems", payload);
        },
    },

    computed: {
        loading() {
            return this.$store.getters.loading;
        },

        categories() {
            return this.$store.getters.categories;
        },
    },
};
</script>
