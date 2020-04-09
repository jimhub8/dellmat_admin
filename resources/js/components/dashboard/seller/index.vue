<template>
<v-content>
    <v-layout justify-center align-center>
        <v-flex sm12>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <el-select allow-create filterable v-model="form.year_f" placeholder="Select Year" style="width: 100%; margin-top: 80px;" @change="countryDash()">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card card-chart" style="background: linear-gradient(90deg,#0c2646,#204065 60%,#2a5788);">
                        <div class="card-body">
                            <div class="chart-area">
                                <SalesChart :height="255" :width="1200" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <myCount />

            <!-- <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-chart">
                        <div class="card-body">
                            <div class="chart-area">
                                <SellerChart :height="255" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card card-chart">
                        <div class="card-body">
                            <div class="chart-area">
                                <ClientChart :height="255" />
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <myCount2 /> -->

        </v-flex>
    </v-layout>
</v-content>
</template>

<script>
import SalesChart from "../../charts/Sales";
import SellerChart from "../../charts/Sellers";
import ClientChart from "../../charts/Clients";
import myCount from './Count'
import myCount2 from './Count2'
export default {
    name: "dashboard",
    components: {
        SalesChart,
        myCount,
        SellerChart,
        ClientChart, myCount2
    },
    props: ["user"],
    data() {
        return {
            form: {
                year_f: new Date().getFullYear()
            },
            options: [{
                value: '2019',
                label: '2019'
            }, {
                value: '2020',
                label: '2020'
            }, {
                value: '2021',
                label: '2021'
            }, {
                value: '2022',
                label: '2022'
            }, ],
        };
    },
    methods: {},
    mounted() {}
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         if (vm.user.can['view users']) {
    //             next();
    //         } else {
    //             next('/unauthorized');
    //         }
    //     })
    // },
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
}
</style>
