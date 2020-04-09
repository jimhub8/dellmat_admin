<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Order Details</span>
                <VSpacer />

                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" icon class="mx-0" @click="close" slot="activator">
                            <v-icon small color="blue darken-2">close</v-icon>
                        </v-btn>
                    </template>
                    <span>close</span>
                </v-tooltip>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <label for="">Status</label>
                <el-select v-model="form.status" filterable clearable placeholder="Status" style="width: 100%;">
                    <el-option v-for="item in status.data" :key="item.status" :label="item.status" :value="item.status">
                    </el-option>
                </el-select>

                <div style="margin: 20px 0"></div>
                <div v-if="form.status == 'Scheduled'">
                    <label for="">Schedule date</label>
                    <el-date-picker style="width: 100%" v-model="form.schedule_date" type="date" placeholder="Pick a day"></el-date-picker>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-btn text color="primary" @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="update" :loading="loading" :disabled="loading">Submit</v-btn>
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
    }),
    created() {
        eventBus.$on("openUpdateStatus", data => {
            this.dialog = true;
            this.form = data;
            this.getStatuses()
        });
    },

    methods: {
        close() {
            this.dialog = false;
        },

        update() {
            var payload = {
                id: this.form.id,
                data: this.form,
                model: 'status_update',
            }
            this.$store.dispatch('postItem', payload)
        },
        getStatuses() {

            var payload = {
                model: 'statuses',
                update_list: 'updateStatusList'
            }
            this.$store.dispatch("getItems", payload);
        },
    },

    computed: {
        status() {
            return this.$store.getters.status;
        },
        loading() {
            return this.$store.getters.loading;
        },
    },
};
</script>
