<template>
<div>
    <div class="col-md-12">
        <div class="card card-stats card-raised">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class>
                                <div class="icon icon-primary">
                                    <v-icon color="orange">shopping_cart</v-icon>
                                </div>
                                <h3 class="info-title">
                                    <span>
                                        <b>{{ total_sales_count }}</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong>Total Sales</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <v-divider vertical></v-divider>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class>
                                <div class="icon icon-success">
                                    <v-icon color="purple">account_circle</v-icon>
                                </div>
                                <h3 class="info-title">
                                    <span>
                                        <b>{{ sellers_count }}</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong>Vendors</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <v-divider vertical></v-divider>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class>
                                <div class="icon icon-info">
                                    <v-icon color="indigo">people</v-icon>
                                </div>
                                <h3 class="info-title">
                                    <span>
                                        <b>{{ clients_count }}</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong>Clients</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <v-divider vertical></v-divider>
                    <div class="col-md-2">
                        <div class="statistics">
                            <div class>
                                <div class="icon icon-danger">
                                    <v-icon color="red">today</v-icon>
                                </div>
                                <h3 class="info-title">
                                    <span>
                                        <b>{{ week_sales_count }}</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong>This week sales</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    methods: {
        getTotalSales() {
            var payload = {
                model: "/total_sales_count",
                update_list: "updateSaleCountList"
            };
            this.$store.dispatch("getItems", payload);
        },
        getWeekSales() {
            var payload = {
                model: "/week_sales_count",
                update_list: "updateWeekSalesCountList"
            };
            this.$store.dispatch("getItems", payload);
        },
        getSellerCount() {
            var payload = {
                model: "/sellers_count",
                update_list: "updateSellerCountList"
            };
            this.$store.dispatch("getItems", payload);
        },
        getClientCount() {
            var payload = {
                model: "/clients_count",
                update_list: "updateClientCountList"
            };
            this.$store.dispatch("getItems", payload);
        }
    },
    computed: {
        total_sales_count() {
            return this.$store.getters.total_sales_count;
        },
        sellers_count() {
            return this.$store.getters.sellers_count;
        },
        clients_count() {
            return this.$store.getters.clients_count;
        },
        week_sales_count() {
            return this.$store.getters.week_sales_count;
        }
    },
    mounted() {
        this.getTotalSales();
        this.getWeekSales();
        this.getSellerCount();
        this.getClientCount();
    }
};
</script>


<style scoped>
.justify-center {
    margin-top: -100px !important;
}

.card-stats {
    margin-top: -10px;
    padding: 20px 0;
}

/* .statistics {
    background: #f0f0f0 !important;
} */

.progress-Ship {
    margin-top: 100px !important;
}

.v-icon {
    font-size: 64px !important;
}

.v-icon {
    box-shadow: 0 9px 30px -6px rgba(255, 54, 54, 0.5);
    padding: 5px;
    border-radius: 50%;
}

.info-title {
    margin-top: 20px;
    color: #000 !important;
}
.stats-title {
    color: #9a9a9a !important;
}
</style>
