<template>
<v-layout align-center>
    <v-flex>
        <div data-v-1bd51565="" data-v-5b54b316="" style="display: flex; flex-wrap: wrap;">
            <div data-v-1bd51565="" class="image-flex-wrapper">
                <div data-v-1bd51565="" class="image-wrapper">
                    <div data-v-1bd51565="" class="icon-image"></div>
                    <!---->
                </div>
            </div>
            <div data-v-1bd51565="" class="details-flex-wrapper">
                <div data-v-1bd51565="" class="details-wrapper">
                    <div data-v-1bd51565="" class="title">
                        <h3 data-v-1bd51565="">{{ product.product_name }}</h3>
                    </div>
                    <p data-v-1bd51565="">Speedball On-hand:
                        <b data-v-1bd51565="">{{ product.onhand }}</b>
                    </p>
                    <p data-v-1bd51565="">Status: <b data-v-1bd51565="">{{ product.active }}</b></p>
                    <div data-v-861aa9f6="" data-v-1bd51565="" class="file-upload-link">
                        <label data-v-861aa9f6="" for="imageUpload">
                                                          <span data-v-861aa9f6="" class="btn-link underline pointer">Upload Image </span>
                                                      </label>
                        <input data-v-861aa9f6="" id="imageUpload" type="file" style="display: none;">
                                                    </div>
                    </div>
                </div>
            </div>
    </v-flex>
</v-layout>
</template>

<script>
export default {
    props: ['product'],
}
</script>

<style scoped>
.icon-image[data-v-1bd51565]:before {
    content: "\E920";
    font-size: 100px;
}

.image-flex-wrapper[data-v-1bd51565] {
    position: relative;
    margin-right: 1em;
    text-align: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
}

.image-flex-wrapper .image-wrapper[data-v-1bd51565] {
    padding: 0.5em;
    border-radius: 6px;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
    border: none;
    height: 10em;
    width: 10em;
}

.icon-image[data-v-1bd51565] {
    background-color: #f9fafb;
    font-size: 5em;
    color: rgba(0, 0, 0, 0.21);
    height: 100%;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-radius: 6px;
}

[class^="icon-"],
[class*=" icon-"] {
    font-family: "Speedball-App" !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal; 
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

[class^="icon-"],
[class*=" icon-"] {
    font-family: "icomoon" !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

[class*=" icon-"],
[class^="icon-"] {
    font-family: icomoon !important;
    speak: none;
    font-style: normal;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>
