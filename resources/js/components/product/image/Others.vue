<template>
<div id="others">
    <v-layout row justify-center>
        <v-container grid-list-md>
            <!-- <v-layout wrap> -->
            <v-layout wrap>
                <v-flex sm6 v-for="image in images" :key="image.id">
                    <img :src="image.image" alt="" style="height: 280px;width: 300px;">
                    <br>
                    <small style="cursor: pointer; color: red;margin-bottom: 5px;" @click="remove(image.id)">remove</small>
                </v-flex>
            </v-layout>
            <!-- <v-flex sm12> -->
            <v-form ref="form" @submit.prevent>
                <div class="large-12 medium-12 small-12 filezone">
                    <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()" />
                    <p>
                        Drop your files here <br>or click to search
                    </p>
                </div>

                <div v-for="(file, key) in files" class="file-listing" :key="key">
                    <img class="preview" v-bind:ref="'preview'+parseInt(key)" />
                    {{ file.name }}
                    <div class="success-container" v-if="file.id > 0">
                        Success
                    </div>
                    <div class="remove-container" v-else>
                        <a class="remove" v-on:click="removeFile(key)">Remove</a>
                    </div>
                </div>
                <v-card-actions>
                    <v-btn text color="primary" @click="files=[]" v-show="files.length > 0">clear</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn :disabled="loading" :loading="loading" text color="primary" @click="submitFiles()" v-show="files.length">Submit</v-btn>
                </v-card-actions>
            </v-form>
            <!-- </v-flex>
        </v-layout> -->
        </v-container>
    </v-layout>
</div>
</template>

<script>
// import VueUploadMultipleImage from 'vue-upload-multiple-image'
export default {
    props: ['product_id'],
    components: {
        // LightBox,/
    },
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
        submitFiles() {
            this.loading = true;
            for (let i = 0; i < this.files.length; i++) {
                if (this.files[i].id) {
                    continue;
                }
                let formData = new FormData();
                formData.append("image", this.files[i]);

                axios
                    .post(`/product_image/${this.product_id}`, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(
                        function (data) {
                            this.loading = false;
                            console.log(this.files.length, i);
                            console.log(data);
                            this.files[i].id = data["data"]["id"];
                            this.files.splice(i, 1, this.files[i]);
                            this.upload_files.push(data.data);
                            if (this.files.length === i + 1) {
                                // this.sendmail();
                                // alert('finish')
                                // this.getImages()
                                // this.clear()
                            }
                            // console.log('success');
                        }.bind(this)
                    )
                    .catch(error => {

                        if (error.response.status === 500) {
                            eventBus.$emit("errorEvent", error.response.statusText);
                            this.loading = false;
                            return;
                        }
                        console.log(error.response.status);
                        this.loading = false;

                        if (error.response.status === 500) {
                            eventBus.$emit("errorEvent", error.response.statusText);
                            return;
                        }
                        console.log("error");
                    })
                    .then(response => {
                        // alert('finish2')
                        eventBus.$emit("alertRequest", "Successifully Created");
                        // this.getImages();
                        this.loading = false;
                        this.clear();
                        // this.sendmail()
                        // console.log(response);
                    });
            }
        },
        getImagePreviews() {
            for (let i = 0; i < this.files.length; i++) {
                if (/\.(jpe?g|png|gif)$/i.test(this.files[i].name)) {
                    let reader = new FileReader();
                    reader.addEventListener(
                        "load",
                        function () {
                            this.$refs["preview" + parseInt(i)][0].src = reader.result;
                        }.bind(this),
                        false
                    );
                    reader.readAsDataURL(this.files[i]);
                } else if (/\.(csv|xls)$/i.test(this.files[i].name)) {
                    this.$nextTick(function () {
                        this.$refs["preview" + parseInt(i)][0].src = "/storage/img/csv.png";
                    });
                } else if (/\.(pdf)$/i.test(this.files[i].name)) {
                    this.$nextTick(function () {
                        this.$refs["preview" + parseInt(i)][0].src = "/storage/img/pdf.png";
                    });
                } else {
                    this.$nextTick(function () {
                        this.$refs["preview" + parseInt(i)][0].src =
                            "/storage/img/file.png";
                    });
                }
            }
        },
        remove(id) {
            if (confirm("Are you sure you want to delete this image?")) {
                this.loading = true;
                axios
                    .delete(`/images/${id}`)
                    .then(response => {
                        this.loading = false;
                        // this.images.splice(index, 1)
                        this.getImages();
                        eventBus.$emit("alertRequest", "Successifully Created");
                    })
                    .catch(error => {
                        this.loading = false;
                        if (error.response.status === 500) {
                            eventBus.$emit("errorEvent", error.response.statusText);
                            return;
                        }
                        this.errors = error.response.data.errors;
                    });
            }
        },
        getImages() {
            axios
                .get(`/images/${this.product_id}`)
                .then(response => {
                    this.images = response.data;
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        eventBus.$emit("errorEvent", error.response.statusText);
                        return;
                    }
                    this.errors = error.response.data.errors;
                });
        },
        clear() {
            this.files = [];
        },
        removeFile(key) {
            this.files.splice(key, 1);
            this.getImagePreviews();
        },
        handleFiles() {
            let uploadedFiles = this.$refs.files.files;

            for (var i = 0; i < uploadedFiles.length; i++) {
                this.files.push(uploadedFiles[i]);
            }
            this.getImagePreviews();
        },
        close() {
            this.actualImage = false;
            // this.dialog = false;
        }
    },
    created() {

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
