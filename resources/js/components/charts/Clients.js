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
        this.getClients(new Date().getFullYear())
        // axios.get('/clients_chart')
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
        getClients(data) {
            console.log(data);

            var payload = {
                model: '/clients_chart',
                update: 'updateClientChartList',
                data: data,
            }

            this.$store.dispatch("filterItems", payload).then((res) => {
                this.setGraph()
            });
        },
        setGraph() {
            this.renderChart({
                labels: this.clients_chart.data.lables,
                // labels: this.label,
                datasets: [
                    {
                        label: 'Clients',
                        backgroundColor: '#1564c0',
                        data: this.clients_chart.data.rows
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
            this.getClients(data)
        });
    },
    computed: {
        clients_chart() {
            return this.$store.getters.clients_chart
        }
    },
}
