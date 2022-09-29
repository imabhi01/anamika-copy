<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">
                    <h3>All Employees</h3>
                </span>
                <div>
                    <router-link :to="{name: 'employees-create'}" class="btn btn-primary">
                        <i class="fas fa-plus-square"></i> New Employee
                    </router-link>
                </div>
            </div>
            <div class="panel-body">
                <search :total_rows="total_rows" :search="search" @getRows="getRows($event)" @liveSearch="liveSearch" />

                <table class="table table-link">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Salary</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                            <td class="w-1 text-center">{{item.id}}</td>
                            <td class="w-3 text-center">{{item.first_name}}</td>
                            <td class="w-3 text-center">{{item.last_name}}</td>
                            <td class="w-5 text-center">{{item.phone}}</td>
                            <td class="w-5 text-center">
                                <img :src="item.image" class="figure-img img-fluid img-rounded preview" alt="">
                            </td>
                            <td class="w-5 text-center">{{item.address}}</td>
                            <td class="w-5 text-center">{{item.salary}}</td>
                            <td class="w-3 text-center">
                                <router-link :to="`/employees/${item.id}`" class="btn">Show</router-link>
                            </td>
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
<script type="text/javascript">
    import Vue from 'vue'
    import { get } from '../../lib/api'
    import search from '../../components/layouts/search'
    export default {
        name: 'EmployeeIndex',
        components:{
            search
        },
        data () {
            return {
                model: {
                    data: []
                },
                search: '',
                total_rows: 10
            }
        },
        beforeRouteEnter(to, from, next) {
            get('/api/employees', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/employees', to.query)
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
                this.$router.push(`/employees/${item.id}`)
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
            }
        }
    }
</script>
<style lang="scss" scoped>
    .preview{
        height: 100px;
    }
</style>