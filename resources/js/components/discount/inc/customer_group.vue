<template>
<div>
    <h5 class="text-center" style="color: #2bbdb9;">CUSTOMER GROUPS</h5>
    <v-divider></v-divider>
    <div>

        <v-radio-group v-model="form.customer">
            <v-radio v-for="n in options" :key="n.value" :label="n.label" :value="n.value"></v-radio>
        </v-radio-group>
        <div v-if="form.customer == 'customer_group'">
            <label for="">Customer group</label>
            <el-select v-model="form.customers" multiple filterable remote reserve-keyword style="width: 60%" placeholder="type at least 3 characters" :remote-method="getClient" :loading="loading">
                <el-option v-for="item in clients.data" :key="item.id" :label="item.name" :value="item.id">
                </el-option>
            </el-select>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                customer: '',
            },
            customers: [],

            options: [{
                value: 'all_customers',
                label: 'All customers'
            }, {
                value: 'customer_group',
                label: 'This particular customer group:'
            }],

        }
    },
    methods: {
        getClient(search) {
            // console.log(search);
            if (search.length > 2) {
                var payload = {
                    model: 'client_search',
                    update_: 'updateClientList',
                    search: search
                }
                this.$store.dispatch("searchItems", payload);
            }
        }
    },
    computed: {
        clients() {
            return this.$store.getters.clients
        }
    },
}
</script>

<style scoped>
label {
    color: #5d5252 !important;
}
</style>
