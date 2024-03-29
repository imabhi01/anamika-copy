<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{model.number}}</span>
            <div>
                <router-link to="/expenses" class="btn">Back</router-link>
                <router-link :to="`/expenses/${model.id}/edit`" class="btn">Edit</router-link>
                <button class="btn btn-error" @click="deleteItem">Delete</button>
                <button class="btn btn-primary" @click="print">Print</button>
            </div>
        </div>
        <div class="panel-body">
            <div class="document">
                <div class="row">
                    <div class="col-6">
                        <strong>From:</strong>
                        <div>
                            <span>{{model.vendor.text}}</span>
                            <pre>{{model.vendor.address}}</pre>
                        </div>
                    </div>
                    <div class="col-6 col-offset-12">
                        <table class="document-summary">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <span class="document-title">Purchase Invoice</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Number</td>
                                    <td>{{model.number}}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>{{model.date}}</td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td>{{model.due_date}}</td>
                                </tr>
                                <tr v-if="model.reference">
                                    <td>Reference</td>
                                    <td>{{model.reference}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="document-body">
                    <table class="table document-table">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in model.items" :key="item.id">
                                <td class="w-3">{{item.item.item_name}}</td>
                                <td class="w-12">
                                    <pre>{{item.item.description}}</pre>
                                </td>
                                <td class="w-3">{{item.unit_price | formatMoney}}</td>
                                <td class="w-2">{{item.qty}}</td>
                                <td class="w-4">{{item.qty * item.unit_price | formatMoney}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Sub Total</td>
                                <td>Rs. {{model.sub_total | formatMoney}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">Discount ( {{model.discount}}% ) </td>
                                <td>Rs. {{(model.sub_total*model.discount)/100 | formatMoney}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">Grand Total</td>
                                <td>Rs. {{model.total | formatMoney}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="document-footer">
                    <strong>Terms and Conditions</strong>
                    <pre>{{model.terms_and_conditions}}</pre>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod} from '../../lib/api'

    export default {
        data () {
            return {
                show: false,
                model: {
                    items: [],
                    vendor: {}
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/expenses/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/expenses/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'model', res.data.model)
                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/expenses/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$toaster.success('Purchase deleted Successfully!')
                            this.$router.push('/expenses')
                        }
                    })
            },
            print(){
                window.print();
            }
        }
    }
</script>
