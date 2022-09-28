<template>
    <div>
        <div class="panel">
            
            <div class="panel-heading">
                <span class="panel-title">Show Payroll</span>
                <div>
                    <button class="btn" @click="goBack">Back</button>
                    <router-link :to="`/payroll/${form.id}/edit`" class="btn">Edit</router-link>
                    <button class="btn btn-error" @click="deleteItem">Delete</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" disabled v-model="form.employee.first_name" placeholder="First Name">
                            <small class="error-control" v-if="errors.first_name">
                                {{errors.first_name[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" disabled v-model="form.employee.last_name" placeholder="Last Name">
                            <small class="error-control" v-if="errors.last_name">
                                {{errors.last_name[0]}}
                            </small>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Salary
                            </label>
                            <input type="text" class="form-control" disabled v-model="form.salary" placeholder="Salary">
                            <small class="error-control" v-if="errors.salary">
                                {{errors.salary[0]}}
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Bonus
                            </label>
                            <input type="text" class="form-control" disabled v-model="form.bonus" placeholder="Bonus">
                            <small class="error-control" v-if="errors.bonus">
                                {{errors.bonus[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Advance
                            </label>
                            <input type="text" class="form-control" disabled v-model="form.advance" placeholder="Advance">
                            <small class="error-control" v-if="errors.advance">
                                {{errors.advance[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Date
                            </label>
                            <input type="date" class="form-control" disabled v-model="form.date" placeholder="Month">
                            <small class="error-control" v-if="errors.date">
                                {{errors.date[0]}}
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
        name: 'EmployeePayrollShow',
        data(){
            return {
                form: {},
                errors: {}
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/payroll/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get(`/api/payroll/${to.params.id}`)
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
                byMethod('delete', `/api/payroll/${this.form.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push(`/employees/${this.form.employee_id}/payroll/history`)
                        }
                    })
            },
            goBack() {
                this.$router.push(`/employees/${this.form.employee_id}/payroll/history`)
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