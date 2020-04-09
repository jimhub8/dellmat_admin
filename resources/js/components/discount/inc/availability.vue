<template>
<div>
    <h5 class="text-center" style="color: #2bbdb9;">CUSTOMER GROUPS</h5>
    <v-divider></v-divider>
    <div>
        <v-radio-group v-model="form.customer_group">
            <v-radio v-for="n in options" :key="n.value" :label="n.label" :value="n.value"></v-radio>
        </v-radio-group>
        <div v-if="form.location == 'all_locations'">
        <label for="">Location</label>
        <el-select v-model="form.discount_type" placeholder="Select" style="width:100%">
            <el-option v-for="item in location" :key="item.value" :label="item.label" :value="item.value">
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
                location: '',
            },
            options: [{
                value: 'all_locations',
                label: 'All locations (current and future):'
            }, {
                value: 'particular_location',
                label: 'Particular location/s (select locations):'
            }],
            locations: [],
        }
    },
    methods: {},
}
</script>

<style scoped>
label {
    color: #5d5252 !important;
}
</style>

