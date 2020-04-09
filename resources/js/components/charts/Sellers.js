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
        this.getSellers(new Date().getFullYear())
        // axios.get('/sellers_chart')
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
        getSellers(data) {
            console.log(data);

            var payload = {
                model: '/sellers_chart',
                update: 'updateSellerChartList',
                data: data,
            }

            this.$store.dispatch("filterItems", payload).then((res) => {
                this.setGraph()
            });
        },
        setGraph() {
            this.renderChart({
                labels: this.sellers_chart.data.lables,
                // labels: this.label,
                datasets: [
                    {
                        label: 'Vendors',
                        backgroundColor: '#f00',
                        data: this.sellers_chart.data.rows
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
            this.getSellers(data)
        });
    },
    computed: {
        sellers_chart() {
            return this.$store.getters.sellers_chart
        }
    },
}
