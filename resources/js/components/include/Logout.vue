<template>
<div class="text-xs-center">
    <v-menu v-model="menu" :close-on-content-click="false" :nudge-width="200" offset-y transition="slide-y-transition">
        <v-btn icon slot="activator" dark>
            <v-icon color="white lighten-1" large>
                account_circle
            </v-icon>
        </v-btn>

        <v-card>
            <v-list>
                <v-list-tile avatar>
                    <v-list-tile-avatar>
                        <avatar :username="user.name" style="font-size: 20px;margin: auto;padding: 0px;"></avatar>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title>{{ user.name }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-divider></v-divider>
                <router-link to="/profile" class="v-list__tile v-list__tile--link">
                    <div class="v-list__tile__action"><i aria-hidden="true" class="icon material-icons">account_circle</i></div>
                    <div class="v-list__tile__content">
                        <div class="v-list__tile__title">
                            My Profile
                        </div>
                    </div>
                </router-link>

            </v-list>

            <v-divider></v-divider>

            <v-card-actions>
                <form action="/logout" method="post">
                    <input type="hidden" name="_token" :value="csrf">
                    <v-tooltip bottom>
                        <!-- <template v-slot:activator="{ on }">

                            <v-btn v-on="on" text slot="activator" color="primary" icon class="mx-0" type="submit">
                                <i class="fa fa-user"></i>
                            </v-btn>
                        </template> -->
                        <span>Logout from this device</span>
                    </v-tooltip>
                </form>

                <form action="/logoutOther" method="get">
                    <input type="hidden" name="_token" :value="csrf">
                    <!-- <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on" text slot="activator" color="orange" icon class="mx-0" type="submit">
                                <i class="fa fa-users"></i>
                            </v-btn>
                        </template>
                        <span>Logout other devices</span>
                    </v-tooltip> -->
                </form>
                <v-spacer></v-spacer>
                <v-btn text @click="menu = false">close</v-btn>
            </v-card-actions>
        </v-card>
    </v-menu>
</div>
</template>

<script>
import Avatar from 'vue-avatar'
export default {
    props: ['user'],
    components: {
        Avatar
    },
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            menu: false,
        }
    },
};
</script>

<style scoped>
.theme--dark.v-btn:not(.v-btn--text):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: transparent !important;
}
</style>
