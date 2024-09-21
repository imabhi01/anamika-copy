<template>
    <div>
        <router-view></router-view>
        <div class="row">

            <div class="col-md-5 chart">
                <LineChart :chart-data="totalExpenseCollection" :options="options"></LineChart> 
            </div>

            <div class="col-md-5 chart">
                <BarChart :chart-data="totalIncomesData" :options="options"></BarChart> 
                <!-- <div class="data">
                    <h3>Total Expenses </h3>
                </div> -->
            </div>
            
            <div class="col-md-5 chart">
                <BarChart :chart-data="totalIncomeCollection" :options="options"></BarChart>
            </div>
            
            <div class="col-md-5 chart">
                <BarChart :chart-data="totalExpensesData" :options="options"></BarChart> 
            </div>

            <!-- <div>
                Pie / Chart (Profit / Loss)
            </div> -->
        </div>
    </div>
</template>

<script>
import navbar from '../components/layouts/Navbar.vue'
import BarChart from '../components/charts/BarChart.vue'
import LineChart from '../components/charts/LineChart.vue'
export default {
    name: 'Home',
    data(){
        return {
            totalIncomeCollection: null,
            totalExpenseCollection: null,
            paidUnpaidCollection: null,
            totalIncomesData: null,
            totalExpensesData: null,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                lineTension: 1,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 25,
                        }
                    }]
                }
            }
        }
    },
    components:{
        navbar,
        BarChart,
        LineChart
    },
    async mounted(){
        this.totalincomes()
        this.fillIncomeData()
        this.totalexpenses()
        this.fillExpenseData()
    },
    methods:{
        async fillIncomeData () {
            const {data} = await axios.get('/api/income/')
            this.totalIncomeCollection = {
                labels: data.invoicePaidLabels,
                datasets: [
                    {
                        label: 'Income Paid',
                        backgroundColor: 'rgba(71, 183,132,.5)',
                        data: data.invoicePaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Income UnPaid',
                        backgroundColor: '#f87979',
                        data: data.invoiceUnPaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 1,
                        fill: false
                    },
                ]
            }
        },
        async fillExpenseData () {
            const {data} = await axios.get('/api/expense/')
            this.totalExpenseCollection = {
                labels: data.expensePaidLabels,
                datasets: [
                    {
                        label: 'Expense Paid',
                        backgroundColor: 'rgba(71, 183,132,.5)',
                        data: data.expensePaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Expense Un Paid',
                        backgroundColor: '#f87979',
                        data: data.expenseUnPaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 1,
                        fill: false
                    },
                ]
            }
        },
        async totalincomes () {
            const {data} = await axios.get('/api/totalincomes/')
            this.totalIncomesData = {
                labels: data.months,
                datasets: [
                    {
                        label: 'Total Income Per Month',
                        backgroundColor: 'rgba(71, 183,132,.5)',
                        data: data.totalIncomeData,
                        borderColor: "#36495d",
                        borderWidth: 1
                    }
                ]
            }
        },
        async totalexpenses () {
            const {data} = await axios.get('/api/totalexpenses/')
            this.totalExpensesData = {
                labels: data.months,
                datasets: [
                    {
                        label: 'Total Expenses Per Month',
                        backgroundColor: '#f87979',
                        data: data.totalExpensesData,
                        borderColor: "#36495d",
                        borderWidth: 1
                    }
                ]
            }
        },
    }

}
</script>

<style lang="scss" scoped>
.row{
    justify-content: center;
    align-items: center;
}
.chart{
    background: #fff;
    margin: 20px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.data{
    margin: 15px;
    text-align: right;
}
</style>