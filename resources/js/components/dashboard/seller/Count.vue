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
                                    <v-icon color="orange">monetization_on</v-icon>
                                </div>
                                <h3 class="info-title">
                                    <span>
                                        <b>KSH {{ week_total_sales_income }}</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong>in last 7 days</strong>
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
                                        <b>{{ week_sold_items }} items</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong>Sold in last 7 days</strong>
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
                                        <b>{{ week_orders }} Orders</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong> received in last 7 days</strong>
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
                                        <b>{{ week_sales_count }} Orders</b>
                                    </span>
                                </h3>
                                <h6 class="stats-title">
                                    <strong> complete in last 7 days</strong>
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
                model: "/week_total_sales_income",
                update_list: "updateWeekTotalSaleCountList"
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
        getWeekItemsCount() {
            var payload = {
                model: "/week_sold_items",
                update_list: "updateWeekSoldItemsCountList"
            };
            this.$store.dispatch("getItems", payload);
        },
        getWeekOrdersount() {
            var payload = {
                model: "/week_orders",
                update_list: "updateWeekOrdersCountList"
            };
            this.$store.dispatch("getItems", payload);
        }
    },
    computed: {
        week_total_sales_income() {
            return this.$store.getters.week_total_sales_income;
        },
        week_sold_items() {
            return this.$store.getters.week_sold_items;
        },
        week_orders() {
            return this.$store.getters.week_orders;
        },
        week_sales_count() {
            return this.$store.getters.week_sales_count;
        }
    },
    mounted() {
        this.getTotalSales();
        this.getWeekSales();
        this.getWeekItemsCount();
        this.getWeekOrdersount();
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
