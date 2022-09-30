<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">
                    <h3>Payroll History</h3>
                </span>
                <div>
                    <button class="btn" @click="goBack">Back</button>
                </div>
            </div>
            <div class="panel-body">
                <search :total_rows="total_rows" :search="search" @getRows="getRows($event)" @liveSearch="liveSearch" />

                <table class="table table-link">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Employee Name</th>
                            <th class="text-center">Month</th>
                            <th class="text-center">Salary</th>
                            <th class="text-center">Bonus</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in model.data" :key="item.data" @click="detailsPage(item)">
                            <td class="w-1 text-center">{{index+1}}</td>
                            <td class="w-3 text-center">{{item.employee.first_name}} {{item.employee.last_name}}</td>
                            <td class="w-3 text-center">{{item.nepaliMonth}}</td>
                            <td class="w-5 text-center">{{item.salary}}</td>
                            <td class="w-5 text-center">{{item.bonus}}</td>
                            <td class="w-5 text-center">{{item.status}}</td>
                            <td class="w-3">
                                <router-link :to="`/payroll/${item.id}/show`" class="btn">Show</router-link>
                            </td>
                        </tr>
                        <tr v-if="!model.data.length" class="text-center">
                            <td colspan = "100%" class="text-center">No Records Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="panel-footer flex-between">
                <div>
                    <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary" :disabled="!model.prev_page_url" @click="prevPage">
                        Prev
                    </button>
                    <button class="btn btn-sm btn-primary" :disabled="!model.next_page_url" @click="nextPage">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
import search from '../../components/layouts/search'

export default {
    name: 'EmployeePayrollHistory',
    components:{
        search
    },
    data () {
        return {
            model: {
                data: []
            },
            search: '',
            total_rows: 10,
            gobackid: ''
        }
    },
    beforeRouteEnter(to, from, next) {
        get(`/api/employees/${to.params.id}/payroll/history/`, to.query)
            .then((res) => {
                next(vm => vm.setData(res))
            })
    },
    beforeRouteUpdate(to, from, next) {
        get('/api/employees/${to.params.id}/payroll/history/', to.query)
            .then((res) => {
                this.setData(res)
                next()
            })
    },
    methods: {
        getRows(event) {
            this.total_rows = event.target.value
            axios.get('/api/employees/get/total_rows', {params: { total_rows : this.total_rows}})
                .then(res => {
                    this.setData(res)
                })
                .catch(error => {
                    console.log(error)
                });
        },
        liveSearch(event){
            this.search = event.target.value
            axios.get('/api/employees/live/search', { params: { q: this.search } })
                .then(res => {
                    this.setData(res)
                })
                .catch(error => {
                    console.log(error)
                });
        },
        detailsPage(item) {
            this.$router.push(`/payroll/${item.id}/show`)
        },
        setData(res) {
            Vue.set(this.$data, 'model', res.data.results)
            this.page = this.model.current_page
            this.$bar.finish()
        },
        nextPage() {
            if(this.model.next_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) + 1) : 2

                this.$router.push({
                    path: '/employees',
                    query: query
                })
            }
        },
        prevPage () {
            if(this.model.prev_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) - 1) : 1

                this.$router.push({
                    path: '/employees',
                    query: query
                })
            }
        },
        goBack(item) {
            this.$router.push(`/employees/${this.$route.params.id}`)
        },
    }
}
</script>