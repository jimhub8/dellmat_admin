<template>
<v-layout row justify-center>
    <v-container grid-list-md>
        <v-layout wrap>
            <v-form ref="form" @submit.prevent>
                <v-divider></v-divider>
                <v-layout row>
                    <v-flex sm8>
                        <img :src="avatar" style="width: 100%; height: 200px;">
                        <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Update Image</v-btn>
                        <input type="file" @change="Getimage" accept="image/*" style="display: none" ref="fileInput">
                        <v-btn text @click="cancle" v-show="imagePlaced">Cancle</v-btn>
                        <v-btn text @click="upload" :disabled="loading" :loading="loading">Update</v-btn>
                    </v-flex>
                    <v-flex sm3 offset-sm-1>
                        <div v-for="image in images" :key="image.id">
                            <img id="image" :src="image.image" :alt="image.id">
                            <small style="cursor: pointer; color: red;margin-bottom: 5px;" @click="remove(image.id)">remove</small>
                        </div>
                    </v-flex>
                    <!-- <LightBox :images="images"></LightBox> -->
                </v-layout>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :disabled="loading" :loading="loading" text color="primary" @click="submitFiles()" v-show="files.length">Submit</v-btn>
                </v-card-actions>
            </v-form>
        </v-layout>
    </v-container>
</v-layout>
</template>

<script>
// import VueUploadMultipleImage from 'vue-upload-multiple-image'
export default {
    components: {
        // LightBox,/
    },
    props: ['product_id'],
    data() {
        return {
            errors: {},
            loading: false,
            // dialog: false,
            disabled: true,
            avatar: "",
            actualImage: false,
            imagePlaced: false,
            files: [],
            upload_files: [],
            product: [],
            images: [],
        };
    },
    methods: {
        close() {
            this.actualImage = false;
            // this.dialog = false;
        },

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

        cancle() {
            this.avatar = this.product.image;
            this.imagePlaced = false;
        },

        upload() {
            this.loading = true;
            var data = {
                'file': this.file,
                'id': this.product_id,
            }
            axios
                .post(`images/${this.product_id}`, this.file)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    eventBus.$emit("alertRequest", 'Successifully uploaded');
                    this.imagePlaced = false;
                    this.color = "black";
                    this.text = "Product image updated";
                    this.snackbar = true;
                    // this.close()
                })
                .catch(error => {
                    this.loading = false
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    }
                    this.errors = error.response.data.errors;
                });
        },
    },
    created() {

        eventBus.$on("openImageEvent", data => {
            this.product = data;
            this.avatar = data.image;
        });
    }
};
</script>

<style scoped>
input[type="file"] {
    opacity: 0;
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
}

.filezone {
    outline: 2px dashed grey;
    outline-offset: -10px;
    background: #ccc;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px;
    position: relative;
    cursor: pointer;
}

.filezone:hover {
    background: #c0c0c0;
}

.filezone p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 50px 50px 50px;
}

div.file-listing img {
    max-width: 90%;
}

div.file-listing {
    margin: auto;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

div.file-listing img {
    height: 100px;
}

div.success-container {
    text-align: center;
    color: green;
}

div.remove-container {
    text-align: center;
}

div.remove-container a {
    color: red;
    cursor: pointer;
}

a.submit-button {
    display: block;
    margin: auto;
    text-align: center;
    width: 200px;
    padding: 10px;
    text-transform: uppercase;
    background-color: #ccc;
    color: white;
    font-weight: bold;
    margin-top: 20px;
}

#image {
    width: 90%;
    height: 150px;
}
</style>
