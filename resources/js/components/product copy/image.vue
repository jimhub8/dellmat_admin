<template>
<div>
    <v-layout row justify-center>
        <v-dialog v-model="dialog" persistent max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="headline text-center" style="margin: auto;">Product image</span>
                    <VSpacer />
                    <v-btn icon class="mx-0" style="float: right" @click="dialog = false">
                        <v-icon color="error darken-2" small>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container fluid fill-height>
                        <v-layout justify-center align-center>
                            <input type="file" @change="Getimage" accept="image/*" style="display: none" ref="fileInput">
                            <img v-show="imagePlaced" :src="avatar" style="max-height: 400px">

                        </v-layout>
                    </v-container>
                </v-card-text>
                <VCardActions>
                    <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Choose Image</v-btn>
                    <VSpacer />
                    <v-btn @click="upload" text v-show="imagePlaced" :loading="loading" :disabled="loading">Upload</v-btn>
                    <!-- <v-btn @click="cancle" text v-show="imagePlaced">Cancel</v-btn> -->
                    <!-- <VBtn color="info" @click="dialog = false">Close</VBtn> -->
                </VCardActions>
            </v-card>
        </v-dialog>
    </v-layout>
</div>
</template>

<script>
export default {
    data() {
        return {
            imagePlaced: false,
            dialog: false,
            loading: false,
            errors: [],
            avatar: "",
            product: [],
        };
    },
    methods: {
        // Image Upload
        onPickFile() {
            this.$refs.fileInput.click();
        },
        onFilePicked(event) {
            this.imagePlaced = true;
            const files = event.target.files;
            let filename = files[0].name;
            if (filename.lastIndexOf(".") <= 0) {
                return alert("please upload a valid image");
            }
            const fileReader = new FileReader();
            fileReader.addEventListener("load", () => {
                this.avatar = fileReader.result;
            });
            fileReader.readAsDataURL(files[0]);
            this.image = files[0];
        },
        Getimage(e) {
            let image = e.target.files[0];
            // this.read(image);
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                this.avatar = e.target.result;
            };
            this.imagePlaced = true;
            let form = new FormData();
            form.append("image", image);
            this.file = form;
            console.log(e.target.files);
        },

        upload() {
            this.loading = true;
            axios
                .post(`/product_image/${this.product.id}`, this.file)
                .then(response => {
                    this.loading = false;
                    eventBus.$emit('alertRequest', 'Image Uploaded')
                    this.dialog = false
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        cancle() {
            this.avatar = this.LogedUser.profile;
            this.imagePlaced = false;
        },
        resetForm() {
            this.LogedUser = Object.assign({}, this.defaultForm);
            this.$refs.LogedUser.reset();
        },
    },
    created() {
        eventBus.$on("openImageEvent", data => {
            this.dialog = true
            this.product = data
                this.avatar = data.image
            if (data.image) {
                this.imagePlaced = true;
            }
        });
    },
};
</script>
