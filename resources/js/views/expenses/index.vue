<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">
                    <h3>All Purchases</h3>
                </span>
                <div>
                    <router-link to="/expenses/create" class="btn btn-primary">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> New Purchase
                    </router-link>
                </div>
            </div>
            <div class="panel-body">
                <search 
                    :total_rows="total_rows" 
                    :search="search"  
                    :first_date="first_date" 
                    :second_date="second_date"
                    :status="status"
                    @filterMethod="filterMethod($event)"
                />
                <table class="table table-link">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Number</th>
                            <th class="text-center">Vendor</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in model.data" :key="item.data" @click="detailsPage(item)">
                            <td class="w-1 text-center">{{index+1}}</td>
                            <td class="w-3 text-center">{{item.date}}</td>
                            <td class="w-3 text-center">{{item.number}}</td>
                            <td class="w-5 text-center">{{item.vendor.text}}</td>
                            <td class="w-3 text-center">{{item.due_date}}</td>
                            <td class="w-3 text-center">
                                <span class="badge bg-success text-center" v-if="item.status == 'Paid'">{{item.status}}</span>
                                <span class="badge bg-danger text-center" v-else-if="item.status == 'Un paid'">{{item.status}}</span>
                            </td>
                            <td class="w-3 text-center">Rs. {{item.total | formatMoney}}</td>
                            <td class="w-3 text-center">
                                <router-link :to="`/expenses/${item.id}`" class="btn">Show</router-link>
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
        <div class="below panel">
            <div><span class="badge badge-primary">Total Turnover</span> <strong>: Rs.{{totalTurnOver}}</strong></div>
            <div><span class="badge badge-success">Total Paid</span><strong>: Rs.{{paidTurnOver}}</strong></div>
            <div><span class="badge badge-danger">Total Unpaid</span><strong>: Rs.{{unPaidTurnOver}}</strong></div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import { get } from '../../lib/api'
    import search from '../../components/layouts/SalesSearch'
    import VNepaliDatePicker from 'v-nepalidatepicker';
    export default {
        components:{
            search
        },
        data () {
            return {
                model: {
                    data: []
                },
                total_rows: 15,
                search: '',
                first_date: '',
                second_date: '',
                status: '',
                paidTurnOver: '',
                unPaidTurnOver: '',
                totalTurnOver: '',
            }
        },
        beforeRouteEnter(to, from, next) {
            get('/api/expenses', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/expenses', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            filterMethod(eventData){
                
                if(eventData.name == 'search'){
                    this.search = eventData.event.target.value
                }

                if(eventData.name == 'total_rows'){
                    this.total_rows = eventData.event.target.value
                }

                if(eventData.name == 'status'){
                    this.status = eventData.event.target.value
                }

                if(eventData.name == 'search-date'){
                    this.first_date = eventData.event[0];
                    this.second_date = eventData.event[1];
                }

                if(eventData.name == 'reset-data'){
                    this.search = ''
                    this.total_rows = 15
                    this.status = ''
                    this.first_date = ''
                    this.second_date = ''
                }
                axios.get('/api/expenses', {
                    params: { 
                        q: this.search,
                        total_rows : this.total_rows,
                        status : this.status,
                        first_date: this.first_date,
                        second_date: this.second_date
                    }
                })
                .then(res => {
                    this.setData(res)
                })
                .catch(error => {
                    console.log(error)
                });
            },
            getSecondDate(event){
                this.second_date = event.target.value
            },
            getFirstDate(event){
                this.first_date = event.target.value
            },
            searchDate(event){
                axios.get('/api/expenses/date/search', { params: {first_date: event[0], second_date: event[1]} })
                    .then(res => {
                        this.setData(res)
                        this.first_date = ''
                        this.second_date = ''
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            detailsPage(item) {
                this.$router.push(`/expenses/${item.id}`)
            },
            setData(res) {
                Vue.set(this.$data, 'model', res.data.results)
                this.page = this.model.current_page
                this.totalTurnOver = res.data.totalTurnOver
                this.paidTurnOver = res.data.paidTurnOver
                this.unPaidTurnOver = res.data.unPaidTurnOver
                this.$bar.finish()
            },
            setQueryData(query){
                query.total_rows = this.total_rows
                query.status = this.status
                query.first_date = this.first_date
                query.second_date = this.second_date
            },
            nextPage() {
                if(this.model.next_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) + 1) : 2
                    this.setQueryData(query);
                    this.$router.push({
                        path: '/expenses',
                        query: query
                    })
                }
            },
            prevPage () {
                if(this.model.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1
                    this.setQueryData(query);
                    this.$router.push({
                        path: '/expenses',
                        query: query
                    })
                }
            }
        }
    }
</script>