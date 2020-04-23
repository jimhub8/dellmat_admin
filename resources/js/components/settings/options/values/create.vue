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
                                    <el-select v-model="form.role" filterable clearable placeholder="Role" style="width: 100%;">
                                        <el-option v-for="item in roles" :key="item.id" :label="item.name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <label for="">Option Value</label>
                                    <el-input placeholder="option" v-model="form.option_name"></el-input>
                                </div>
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
        form: {},
        errors: {},
        payload: {
            model: 'option_values',
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
        }
    },

    computed: {
        loading() {
            return this.$store.getters.loading;
        },
    },
};
</script>
