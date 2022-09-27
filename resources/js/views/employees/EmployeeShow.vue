<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{form.number}}</span>
                <div>
                    <router-link to="/employees" class="btn">Back</router-link>
                    <router-link :to="`/employees/${form.id}/edit`" class="btn">Edit</router-link>
                    <router-link :to="`/employees/${form.id}/payroll`" class="btn">Pay Salary</router-link>
                    <router-link :to="`/employees/${form.id}/payroll/history`" class="btn">Show History</router-link>
                    <button class="btn btn-error" @click="deleteItem">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" disabled v-model="form.first_name" placeholder="First Name">
                            <small class="error-control" v-if="errors.first_name">
                                {{errors.first_name[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" disabled v-model="form.last_name" placeholder="Last Name">
                            <small class="error-control" v-if="errors.last_name">
                                {{errors.last_name[0]}}
                            </small>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Phone
                            </label>
                            <input type="text" class="form-control" disabled v-model="form.phone" placeholder="Phone">
                            <small class="error-control" v-if="errors.phone">
                                {{errors.phone[0]}}
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Address
                            </label>
                            <input type="text" class="form-control" disabled v-model="form.address" placeholder="Address">
                            <small class="error-control" v-if="errors.address">
                                {{errors.address[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Joining Date
                            </label>
                            <input type="date" class="form-control" disabled v-model="form.joining_date" placeholder="Joining Date">
                            <small class="error-control" v-if="errors.joining_date">
                                {{errors.joining_date[0]}}
                            </small>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" class="form-control" disabled v-model="form.salary" placeholder="Password Confirmation">
                            <small class="error-control" v-if="errors.salary">
                                {{errors.salary[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Image</label>
                            <div class="mt-3">
                                <img :src="form.image" class="figure-img img-fluid img-rounded preview" alt="">
                            </div>
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
        name: 'EmployeeShow',
        data(){
            return {
                form: {},
                errors: {}
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/employees/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get(`/api/employees/${to.params.id}`)
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
                byMethod('delete', `/api/employees/${this.form.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/employees')
                        }
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
.figure-img {
  margin-bottom: 0.5rem;
  line-height: 1;
  object-fit: cover;
  height: 250px;
  width: 250px;
  border-radius: 10px;
}
</style>