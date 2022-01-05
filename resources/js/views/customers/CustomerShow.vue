<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{form.number}}</span>
                <div>
                    <router-link to="/customers" class="btn">Back</router-link>
                    <router-link :to="`/customers/${form.id}/edit`" class="btn">Edit</router-link>
                    <button class="btn btn-error" @click="deleteItem">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" disabled v-model="form.firstname" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" disabled v-model="form.lastname" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Email
                            </label>
                            <input type="email" class="form-control" disabled v-model="form.email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Phone
                            </label>
                            <input type="text" class="form-control" disabled v-model="form.phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" disabled v-model="form.address" placeholder="Address">
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
        name: 'CustomerShow',
        data(){
            return {
                form: {},
                errors: {}
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/customers/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get(`/api/customers/${to.params.id}`)
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
                byMethod('delete', `/api/customers/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/customers')
                        }
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>