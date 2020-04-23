<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Option</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex sm12>
                            <v-card-text>
                                <div>
                                    <label for="">Option</label>
                                    <el-input placeholder="option" v-model="form.option_name"></el-input>
                                </div>

                                <div>
                                    <label for="">Option Values</label>
                                    <el-input placeholder="option" v-for="(option_value, index) in form.option_values_arr" :key="index" v-model="option_value.option_name"></el-input>
                                </div>

                                <v-btn text icon color="primary" @click="add_new">
                                    <v-icon>add</v-icon>
                                </v-btn>
                            </v-card-text>
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
        form: {
            option_values_arr: [{
                option_name: ''
            }]
        },
        errors: {},
        payload: {
            model: 'product_options',
        },
    }),
    created() {
        eventBus.$on("openCreateOption", data => {
            this.dialog = true;
        });
    },

    methods: {
        save() {
            this.payload['data'] = this.form
            this.$store.dispatch('postItems', this.payload)
                .then(response => {
                    eventBus.$emit("OptionEvent")
                });
        },
        close() {
            this.dialog = false;
        },
        add_new() {
            this.form.option_values_arr.push({
                option_name: ''
            })
        }
    },

    computed: {
        loading() {
            return this.$store.getters.loading;
        },
    },
};
</script>
