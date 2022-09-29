<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{form.id}}</span>
                <div>
                    <router-link to="/items" class="btn">Back</router-link>
                    <router-link :to="`/items/${form.id}/edit`" class="btn">Edit</router-link>
                    <button class="btn btn-error" @click="deleteItem">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" class="form-control" disabled v-model="form.item_name" placeholder="Item Name">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" disabled v-model="form.description" placeholder="Description">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" disabled v-model="form.unit_price" placeholder="Unit Price">
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
        name: 'ItemShow',
        data(){
            return {
                form: {},
                errors: {}
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/items/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get(`/api/items/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'form', res.data.model)
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/items/${this.form.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$toaster.success('Item deleted Successfully!')
                            this.$router.push('/items')
                        }
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>