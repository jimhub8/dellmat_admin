<template>
    <div>
        <myAdminDashboard v-if="user.is_admin" />
        <!-- <mySellerDashboard /> -->
        <mySellerDashboard  v-if="user.is_seller" />
    </div>
</template>
<script>
import myAdminDashboard from './admin'
import mySellerDashboard from './seller'
export default {
    props: ['user'],
    components: {
        myAdminDashboard, mySellerDashboard
    },


}
</script>
<style scoped>
</style>
