<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{form.number}}</span>
                <div>
                    <router-link to="/products" class="btn">Back</router-link>
                    <router-link :to="`/products/${form.id}/edit`" class="btn">Edit</router-link>
                    <button class="btn btn-error" @click="deleteItem">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Item Code</label>
                            <input type="text" class="form-control" disabled v-model="form.item_code" placeholder="Item Code">
                            <small class="error-control" v-if="errors.item_code">
                                {{errors.item_code[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" disabled v-model="form.description" placeholder="Description">
                            <small class="error-control" v-if="errors.description">
                                {{errors.description[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Unit Price
                            </label>
                            <input type="number" class="form-control" disabled v-model="form.unit_price" placeholder="Unit Price">
                            <small class="error-control" v-if="errors.unit_price">
                                {{errors.unit_price[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Quantity
                            </label>
                            <input type="number" class="form-control" disabled v-model="form.quantity" placeholder="Quantity">
                            <small class="error-control" v-if="errors.quantity">
                                {{errors.quantity[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Unit
                            </label>
                            <select name="unit" v-model="form.unit" class="form-control" disabled>
                                <option value="" selected disabled>Select Unit</option>
                                <option value="Kg">Kg</option>
                                <option value="Pc">Pc</option>
                                <option value="Dozen">Dozen</option>
                                <option value="Packets">Packets</option>
                            </select>
                            
                            <small class="error-control" v-if="errors.unit">
                                {{errors.unit[0]}}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {get, byMethod} from '../../lib/api'

    export default {
        name: 'ProductShow',
        data(){
            return {
                form: {},
                errors: {}
            }
        },
        beforeRouteEnter (to, from, next) {
            get(`/api/products/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next){
            get(`/api/products/${to.params.id}`)
                .then((res) => {
                    vm.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'form', res.data.model)
                this.$bar.finish()
            },
            deleteItem(){
                byMethod('delete',`/api/products/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/products')
                        }
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>