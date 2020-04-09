//Importing Line class from the vue-chartjs wrapper
import { Line } from 'vue-chartjs'
//Exporting this so it can be used in other components
export default {
    // extend: Line,
    extends: Line,
    data() {
        return {
            label: [],
            rows: []
        }
    },
    mounted() {
        this.getSales(new Date().getFullYear())
        // axios.get('/sales_chart')
        //     .then((response) => {
        //         // console.log(response);
        //         this.label = response.data.data.lables
        //         this.rows = response.data.data.rows
        //         this.setGraph()
        //     })
        //     .catch((error) => {
        //         this.errors = error.response.data.errors
        //     })

    },
    methods: {
        getSales(data) {
            console.log(data);

            var payload = {
                model: '/sales_chart',
                update: 'updateSaleChartList',
                data: data,
            }

            this.$store.dispatch("filterItems", payload).then((res) => {
                this.setGraph()
            });
        },
        setGraph() {
            this.renderChart({
                labels: this.sales_chart.data.lables,
                // labels: this.label,
                datasets: [
                    {
                        label: 'Sales',
                        backgroundColor: '#566c86',
                        data: this.sales_chart.data.rows
                        // data: this.rows
                    }
                ]
            }, { responsive: true, maintainAspectRatio: false })
        },
        ref(data) {
            axios.post('/getChartData', data)
                .then((response) => {
                    // console.log(response);
                    this.label = response.data.data.lables
                    this.rows = response.data.data.rows
                    this.setGraph()
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        }
    },
    created() {
        eventBus.$on('chartEvent', data => {
            this.label = data.lables
            this.data = data.rows
        });
        eventBus.$on('DashchartEvent', data => {
            this.getSales(data)
        });
    },
    computed: {
        sales_chart() {
            return this.$store.getters.sales_chart
        }
    },
}
