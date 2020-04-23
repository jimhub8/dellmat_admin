<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Permissions</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-layout wrap>
                    <v-flex xs6 sm3 v-for="perm in permissions" :key="perm.id">
                        <v-checkbox v-model="selected" :label="perm.name" :value="perm.name"></v-checkbox>
                    </v-flex>
                </v-layout>
            </v-card-text>

            <v-card-actions>
                <!-- <v-btn text @click="resetForm">reset</v-btn> -->
                <v-btn text @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn :disabled="loading" text color="primary" @click="save" :loading="loading">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            loading: false,
            form: [],
            selected: [],
        }
    },
    methods: {
        save() {
            this.loading = true
            axios.post(`/permisions/${this.form.id}`, {
                selected: this.selected
            }).
            then((response) => {
                    // console.log(response);
                    this.loading = false
                    this.$emit('alertRequest');
                    this.close();
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm)
            this.$refs.form.reset()
        },
        close() {
            this.dialog = false
        },

        getUserPerm(item) {
            axios.post(`/getUserPerm/${item.id}`, item).then((response) => {
                this.selected = response.data
            }).catch((error) => {
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                }
                this.errors = error.response.data.errors
            })
        }
    },
    created() {
        eventBus.$on('permEvent', data => {
            console.log(data);

            // this.selected = data;
            this.form = data;
            this.dialog = true
            this.getUserPerm(data)
        });
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                this.form.password &&
                this.form.branch &&
                this.form.address &&
                this.form.city &&
                this.form.company
            )
        },

        permissions() {
            return this.$store.getters.permissions
        },
        // sortPerm() {
        //     return _.orderBy(this.permissions, 'name', 'asc')
        // }
    },
}
</script>
