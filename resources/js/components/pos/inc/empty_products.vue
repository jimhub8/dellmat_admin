<template>
<v-hover style="padding: 50px 0">
    <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
        <div class="text-center">
            <h3>No products available</h3>
            <p style="color: #000">Want to start selling, Get started by creating some products</p>
            <!-- <v-btn color="primary" rounded @click="openCreate">Create Product</v-btn> -->
            <!-- <v-spacer></v-spacer> -->
            <v-btn color="primary" rounded @click="openProducts">Go to products page</v-btn>
        </div>
    </v-card>
    <myCreate></myCreate>
</v-hover>
</template>

<script>
import myCreate from '../../product/create'
export default {
    components: {
        myCreate,
    },
    data() {
        return {};
    },
    methods: {
        openProducts(data) {
            this.$router.push({
                name: "products",
            });
        },

        openCreate() {
            eventBus.$emit("openCreateProduct");
        },
    },
};
</script>
