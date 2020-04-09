<template>
<v-item-group>
    <h3 class="text-center">Pricing</h3>
    <VDivider/>
    <v-container grid-list-md>
        <table class="table table-hover table-striped">
            <thead>
                <th>You cost</th>
                <th>Quantity</th>
                <th>Reorder point</th>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" v-model="sku_values.price" class="form-control"></td>
                    <td><input type="text" v-model="sku_values.quantity" class="form-control"></td>
                    <td><input type="text" v-model="sku_values.reorder_point" class="form-control"></td>
                </tr>
            </tbody>
        </table>
    </v-container>
</v-item-group>
</template>

<script>
export default {
    props: ['product', 'sku_values'],
    data() {
        return {
        }
    },
}
</script>
