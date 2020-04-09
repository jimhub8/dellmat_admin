<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Discount</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                            <v-flex sm12>
                                <v-card-text>
                                    <div>
                                        <label for="">Discount Name</label>
                                        <el-input placeholder="Discount name" v-model="form.discount_name"></el-input>
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
        loading: false,
        form: {},
        payload: {
            model: 'discounts',
        },
    }),
    created() {
        eventBus.$on("openEditDiscount", data => {
            this.form = data
            this.dialog = true;
        });
    },

    methods: {
        save() {
            this.payload['data'] = this.form
            this.$store.dispatch('patchItems', this.payload)
        },
        close() {
            this.dialog = false;
        }
    },
};
</script>
