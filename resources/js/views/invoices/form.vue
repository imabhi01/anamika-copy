<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">{{title}} Billing</span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label>Customer</label>
                        <typeahead :url="customerURL" :initialize="form.customer"
                            @input="onCustomer" />
                        <small class="error-control" v-if="errors.customer_id">
                            {{errors.customer_id[0]}}
                        </small>
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="">(Add if not on list)</label>
                        <router-link :to="{path: '/customers/create'}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Add New Party</router-link>
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label>
                            Number
                            <small>Auto Generated</small>
                        </label>
                        <span class="form-control">{{form.number}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label>Date :</label>
                        <v-nepalidatepicker classValue="form-control" v-model="form.date" calenderType="Nepali" :monthSelect="false" :yearSelect="false"/>
                         <small class="error-control" v-if="errors.date">
                            {{errors.date[0]}}
                        </small>
                    </div>
                </div>
                
                <div class="col-8">
                    <div class="form-group">
                        <label>Due Date :</label>
                        <v-nepalidatepicker classValue="form-control" v-model="form.due_date" calenderType="Nepali" :monthSelect="false" :yearSelect="false"/>
                        <small class="error-control" v-if="errors.due_date">
                            {{errors.due_date[0]}}
                        </small>
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label>
                            Reference
                            <small>Optional</small>
                        </label>
                        <input type="text" class="form-control" v-model="form.reference">
                        <small class="error-control" v-if="errors.reference">
                            {{errors.reference[0]}}
                        </small>
                    </div>
                </div>
            </div>
            <hr>
            <table class="form-table">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in form.items">
                        <td class="w-14">
                            <typeahead :url="productURL" :initialize="item.product"
                                @input="onProduct(index, $event)" />
                            <small class="error-control" v-if="errors[`items.${index}.product_id`]">
                                {{errors[`items.${index}.product_id`][0]}}
                            </small>
                        </td>
                        <td class="w-4">
                            <input type="number" class="form-control" v-model="item.unit_price">
                            <small class="error-control" v-if="errors[`items.${index}.unit_price`]">
                                {{errors[`items.${index}.unit_price`][0]}}
                            </small>
                        </td>
                        <td class="w-2">
                            <input type="number" class="form-control" v-model="item.qty">
                            <small class="error-control" v-if="errors[`items.${index}.qty`]">
                                {{errors[`items.${index}.qty`][0]}}
                            </small>
                        </td>
                        <td class="w-4">
                            <span class="form-control">
                                {{Number(item.qty) * Number(item.unit_price) | formatMoney}}
                            </span>
                        </td>
                        <td>
                            <span class="form-remove" @click="removeItem(index, form.id, item.product_id, item.qty)">&times;</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-success"
                             @click="addNewLine"><i class="fa fa-plus-square"></i> Add New Product</button>
                        </td>
                        <td class="form-summary">Sub Total</td>
                        <td>Rs. {{subTotal | formatMoney}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="form-summary">Discount (%)</td>
                        <td>
                            <input type="number" class="form-control" v-model="form.discount" @keyup="discountedValue()">
                            <small class="form-control" v-if="errors.discount">
                                {{errors.discount[0]}}
                            </small>
                            <small v-if="discountValue">
                                Discount Value : Rs. {{ discountValue }}
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="form-summary">Extra Cost (Thela)</td>
                        <td>
                            <input type="number" class="form-control" v-model="form.extra_cost">
                            <small class="form-control" v-if="errors.extra_cost">
                                {{errors.extra_cost[0]}}
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="form-summary">Grand Total</td>
                        <td>Rs. {{total | formatMoney}}</td>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Terms and Conditions</label>
                        <textarea class="form-control" v-model="form.terms_and_conditions"></textarea>
                        <small class="error-control" v-if="errors.terms_and_conditions">
                            {{errors.terms_and_conditions[0]}}
                        </small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Select Status</label>
                        <select name="status" id="" class="form-control" v-model="form.status">
                            <option value="" selected disabled>Select Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Un paid">Un Paid</option>
                        </select>
                        <small class="error-control" v-if="errors.status">
                            {{errors.status[0]}}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer flex-end">
            <div>
                <button class="btn btn-primary" @click="onSave">Save</button>
                <button class="btn" :disabled="isProcessing" @click="onCancel">Cancel</button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod } from '../../lib/api'
    import {Typeahead } from '../../components/typeahead'
    import VNepaliDatePicker from 'v-nepalidatepicker';

    function initialize(to) {
        let urls = {
            'create': `/api/invoices/create`,
            'edit': `/api/invoices/${to.params.id}/edit`
        }

        return (urls[to.meta.mode] || urls['create'])
    }
    export default {
        components: { Typeahead},
        data () {
            return {
                form: {
                    status: ''
                },
                discountValue:'',
                errors: {},
                isProcessing: false,
                show: false,
                resource: '/invoices',
                store: '/api/invoices',
                method: 'POST',
                title: 'Create',
                productURL: '/api/search/products',
                customerURL: '/api/customers/search'
            }
        },
        beforeRouteEnter(to, from, next) {
            get(initialize(to))
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(initialize(to))
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        mounted(){
            this.form.status = 'Paid'
        },
        computed: {
            subTotal() {
                return this.form.items.reduce((carry, item) => {
                    return carry + (Number(item.unit_price) * Number(item.qty))
                }, 0)
            },
            total() {
                return this.subTotal - (this.subTotal * Number(this.form.discount)) / 100
            }
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'form', res.data.form)

                if(this.$route.meta.mode === 'edit') {
                    this.store = `/api/invoices/${this.$route.params.id}`
                    this.method = 'PUT'
                    this.title = 'Edit'
                }

                this.show = true
                this.$bar.finish()
            },
            addNewLine() {
                this.form.items.push({
                    product_id: null,
                    product: null,
                    unit_price: 0,
                    qty: 1
                })
            },
            onCustomer(e) {
                const customer = e.target.value
                Vue.set(this.$data.form, 'customer', customer)
                Vue.set(this.$data.form, 'customer_id', customer.id)
            },
            onProduct(index, e) {
                const product = e.target.value
                Vue.set(this.form.items[index], 'product', product)
                Vue.set(this.form.items[index], 'product_id', product.id)

                Vue.set(this.form.items[index], 'unit_price', product.unit_price)
            },
            removeItem(index, invoiceId, itemId, qty) {
                if(this.$route.meta.mode === 'edit'){
                    byMethod('POST', '/api/invoices/item/remove/'+ invoiceId + '/' + itemId + '/' + qty, this.form)
                    .then((res) => {
                        if(res.removed){
                            this.form.items.splice(index, 1)
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                }
                this.form.items.splice(index, 1)
            },
            discountedValue(){
                this.discountValue = (this.subTotal * Number(this.form.discount)) / 100
            },
            onCancel() {
                if(this.$route.meta.mode === 'edit') {
                    this.$router.push(`${this.resource}/${this.form.id}`)
                } else {
                    this.$router.push(`${this.resource}`)
                }
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                byMethod(this.method, this.store, this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.$toaster.success('Billing Created Successfully!')
                            this.success(res)
                        }
                    })
                    .catch((error) => {
                        if(error.response.status === 422) {
                            this.$toaster.warning('Please fill in the required fields!')
                            this.errors = error.response.data.errors
                        }
                        this.isProcessing = false
                    })
            },
            success(res) {
                this.$router.push(`${this.resource}/${res.data.id}`)
            }
        }
    }
</script>
