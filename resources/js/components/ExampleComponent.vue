<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                api_key: process.env.MIX_ALGOLIA_APP_ID,
                secret_key: process.env.MIX_ALGOLIA_SECRET,
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
