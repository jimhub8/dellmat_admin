<template>
<v-content>
    <v-layout row justify-center>
        <v-dialog v-model="dialog" persistent max-width="800px">
            <v-container fluid fill-height>
                <v-layout justify-center align-center>
                    <template>
                        <v-card class="mx-auto" style="width: 800px;">
                            <v-card-title class="title font-weight-regular justify-space-between">
                                <span>{{ currentTitle }}</span>
                                <v-avatar color="primary lighten-2" class="subheading white--text" size="24" v-text="step"></v-avatar>
                                <v-spacer></v-spacer>
                                <v-btn icon dark @click="close">
                                    <v-icon color="black">close</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-window v-model="step">
                                <v-window-item :value="1">
                                    <Display :product_id="product_id"></Display>
                                </v-window-item>

                                <v-window-item :value="2">
                                    <Others :product_id="product_id"></Others>
                                </v-window-item>

                            </v-window>

                            <v-divider></v-divider>

                            <v-card-actions>
                                <v-btn :disabled="step === 1" text @click="step--" color="orange">
                                    Display
                                </v-btn>
                                <v-spacer></v-spacer>
                                <v-btn text :disabled="step === 2" color="primary" depressed @click="step++">
                                    More images
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                </v-layout>
            </v-container>
        </v-dialog>
    </v-layout>
</v-content>
</template>

<script>
import Display from './Display';
import Others from './Others';

export default {
    name: 'images',
    props: ["user"],
    components: {
        Display,
        Others,
    },
    data: () => ({
        // length: 3,
        // window: 0,
        dialog: false,
        step: 1,
        files: [],
        upload_files: [],
        product: [],
        images: [],
        product_id: null,
    }),
    computed: {
        currentTitle() {
            switch (this.step) {
                case 1:
                    return 'Image displayed'
                case 2:
                    return 'More images'
                default:
                    return 'Image displayed'
            }
        }
    },
    methods: {
        close() {
            this.dialog = false;
        },
    },
    created() {
        eventBus.$on("openImageEvent", data => {
            // alert('dialog')
            console.log(data);

            this.product = data;
            this.avatar = data.image;
            this.dialog = true;
            this.product_id = data.id
            // this.getImages()
        });
    }
}
</script>
