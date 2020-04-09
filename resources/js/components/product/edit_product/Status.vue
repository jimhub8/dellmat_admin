<template>
<v-item-group>
    <h3 class="text-center">INVENTORY</h3>
    <VDivider/>
    <v-container grid-list-md>
        <h3>Track inventory for this product</h3>
        <v-layout wrap>
            <v-switch v-model="product.active" label="Active" v-if="switch_status" color="primary"></v-switch>
            <v-switch v-model="product.active" label="Inactive" v-else></v-switch>
        </v-layout>
        <v-layout wrap>
            <v-switch v-model="product.virtual" label="Would you like Hike to track inventory movement for this product?" v-if="switch_status" color="primary"></v-switch>
            <v-switch v-model="product.virtual" label="Would you like Hike to track inventory movement for this product?" v-else></v-switch>
        </v-layout>
    </v-container>
</v-item-group>
</template>

<script>
export default {
    props: ['product'],
    data() {
        return {
            active: false,
            switch_status: true
        }
    },
    methods: {
        activeStatus() {
            this.active = true
        },
        inactiveStatus() {
            this.active = false
        },
    },
}
</script>
