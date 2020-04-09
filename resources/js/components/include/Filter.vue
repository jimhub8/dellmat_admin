<template>
<VCard style="width: 100%">
    <v-layout row>
        <v-flex sm2 style="margin-left: 20px; margin-bottom: 20px;" v-if="user.is_admin">
            <label for="">User</label>
            <el-select v-model="form.client" placeholder="User" clearable filterable>
                <el-option v-for="item in clients.data" :key="item.id" :label="item.name" :value="item.id">
                </el-option>
            </el-select>
        </v-flex>
        <v-flex sm2 style="margin-left: 5px; margin-bottom: 20px;">
            <label>Start date</label>
            <el-date-picker v-model="form.start_date" type="date" placeholder="Pick a day">
            </el-date-picker>
        </v-flex>
        <v-flex sm2 style="margin-left: 10px; margin-bottom: 20px;">
            <label>End date</label>
            <el-date-picker v-model="form.end_date" type="date" placeholder="Pick a day">
            </el-date-picker>
        </v-flex>
        <v-flex sm2 style="margin-left: 10px; margin-bottom: 20px;">
            <v-tooltip bottom>
                <v-btn icon class="mx-0" @click="sale_filter" slot="activator" style="margin-top: 32px;">
                    <v-icon small color="blue darken-2">search</v-icon>
                </v-btn>
                <span>Filter</span>
            </v-tooltip>
        </v-flex>
    </v-layout>
</VCard>
</template>

<script>
export default {
    props: ['form', 'user'],
    data() {
        return {
        }
    },
    methods: {
        getUsers() {
            var payload = {
                model: 'users',
                update: 'updateUsersList',
            }

            this.$store.dispatch('getItems', payload)
                .then(() => {
                    this.loader = false
                })
        },
        sale_filter() {
            this.$store.dispatch('sale_filter', this.form)
        }
    },
    mounted() {
        this.getUsers()
    },
    computed: {
        sales() {
            return this.$store.getters.sales
        },
        clients() {
            return this.$store.getters.clients
        }
    },
}
</script>
