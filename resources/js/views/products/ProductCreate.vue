<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Add Particular</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Item Code</label>
                            <input type="text" class="form-control" v-model="form.item_code" placeholder="Item Code">
                            <small class="error-control" v-if="errors.item_code">
                                {{errors.item_code[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" v-model="form.description" placeholder="Description">
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
                            <input type="number" class="form-control" v-model="form.unit_price" placeholder="Unit Price">
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
                            <input type="number" class="form-control" v-model="form.quantity" placeholder="Quantity">
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
                            <select name="unit" v-model="form.unit" class="form-control">
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
            <div class="panel-footer flex-end">
                <div>
                    <button class="btn btn-primary" :disabled="isProcessing" @click="onSave">Save</button>
                    <button class="btn" :disabled="isProcessing" @click="onCancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {get, byMethod } from '../../lib/api'
    export default {
        name: 'ProductCreate',
        data(){
            return {
                form: {},
                isProcessing: false,
                store: `/api/products`,
                method: 'POST',
                title: 'Product Create',
                resource: '/products',
                show: false
            }
        },
        methods:{
            errors(){
                console.log('error');
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                byMethod(this.method, this.store, this.form)
                    .then((res) => {
                        if(res.data && res.data.saved) {
                            this.$toaster.success('Particular Created Successfully!')
                            this.$router.push({name: 'products'})
                            // this.success(res)
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
            onCancel() {
                this.$router.push({name: 'products'}).catch();
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>