<template>
<!-- <v-toolbar absolute :color="color" dark scroll-off-screen scroll-target="#scrolling-techniques">
        <v-toolbar-side-icon></v-toolbar-side-icon>

        <v-toolbar-title>Categories</v-toolbar-title>

        <v-spacer></v-spacer>

        <VBtn color="normal">All</VBtn>

        <v-btn icon>
            <v-icon>favorite</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>more_vert</v-icon>
        </v-btn>
    </v-toolbar> -->
<!-- <div id="scrolling-techniques" class="scroll-y" style="max-height: 100vh;"> -->
<!-- <v-container style="height: 90vh;"> -->
<v-col cols="12" sm="8">
    <v-row>
        <v-col cols="12" sm="3" v-for="product in products.data" :key="product.id">
            <v-hover v-slot:default="{ hover }" open-delay="200" close-delay="200">
                <v-card :elevation="hover ? 16 : 2" class="mx-auto" @click="addCart(product)">
                    <v-img :aspect-ratio="16/9" :src="product.image"></v-img>
                    <v-card-title>
                        <div>
                            <small>{{ product.product_name }}</small>
                            <div class="d-flex">
                                <div class="grey--text text--darken-2">
                                    <!-- <small>{{ product.quantity }}|</small> -->
                                    <!-- <small style="float: right;color: rgb(219, 50, 77);">KSH{{ product.price }}</small> -->
                                </div>
                            </div>
                        </div>
                    </v-card-title>
                </v-card>
            </v-hover>
        </v-col>
    </v-row>
    <myVariants></myVariants>
</v-col>
</template>

<script>
// import myCart from './cart'
import myVariants from './variants'
export default {
    components: {
        myVariants,
    },
    data() {
        return {
            color: '#1867c0',
        }
    },
    methods: {
        addCart(product) {
            // console.log(product);
            if (product.product_variants.length > 0) {
                eventBus.$emit('selectVariantsEvent', product)
                // this.select_variants()
                return
            }

            eventBus.$emit('addCartEvent', product)
            // this.$store.dispatch('addCart', product)
        },
    },
    computed: {
        products() {
            return this.$store.getters.products;
        },

        isLoading() {
            return this.$store.getters.loading;
        }
    },
}
</script>
