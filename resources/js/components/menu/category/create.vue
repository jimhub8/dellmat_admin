<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Menu</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs12 style="padding: 7px 10px 20px 10px;">
                            <label for="" style="color: #52627d;">Menu</label>
                            <el-select v-model="form.menu_id" filterable clearable placeholder="Select menu" style="width:100%;">
                                <el-option v-for="item in menu.data" :key="item.id" :label="item.menu" :value="item.id">
                                </el-option>
                            </el-select>
                        </v-flex>
                        <v-flex sm12>
                            <v-card-text>
                                <div>
                                    <label for="">Menu</label>
                                    <el-input placeholder="Tops..." v-model="form.category"></el-input>
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
            model: 'categories',
        },
    }),
    created() {
        eventBus.$on("openCreateCategory", data => {
            this.dialog = true;
        });
    },

    methods: {
        save() {
            this.payload['data'] = this.form
            this.$store.dispatch('postItems', this.payload)
                .then(response => {
                    eventBus.$emit("CategoryEvent")
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
        menu() {
            return this.$store.getters.menu;
        },
    },
};
</script>
