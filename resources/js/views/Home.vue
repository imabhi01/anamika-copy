<template>
    <div>
        <router-view></router-view>
        <div class="row">
            <!-- <div class="col-12">
                <line-chart :chart-data="totalIncomesData" :options="options"></line-chart> 
            </div>
            <div class="col-12">
                <line-chart :chart-data="totalIncomeCollection" :options="options"></line-chart>
            </div>
            
            <div class="col-12">
                <line-chart :chart-data="totalExpensesData" :options="options"></line-chart> 
            </div> -->
            <div class="col-12">
                <line-chart :chart-data="totalExpenseCollection" :options="options"></line-chart> 
            </div>
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
                        borderWidth: 3
                    },
                    {
                        label: 'Income UnPaid',
                        backgroundColor: '#f87979',
                        data: data.invoiceUnPaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 3
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
                        backgroundColor: '#d62856',
                        data: data.expensePaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 3
                    },
                    {
                        label: 'Expense Un Paid',
                        backgroundColor: '#f87979',
                        data: data.expenseUnPaidDataCollection,
                        borderColor: "#36495d",
                        borderWidth: 3
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
                        borderWidth: 3
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
                        backgroundColor: '#d62856',
                        data: data.totalExpensesData,
                        borderColor: "#36495d",
                        borderWidth: 3
                    }
                ]
            }
        },
    }

}
</script>

<style lang="scss" scoped>

</style>