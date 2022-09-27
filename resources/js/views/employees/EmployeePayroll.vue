<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Employee Payroll</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="show">Employee</label>
                            <select name="employee_id" id="select-rows" @change="$emit('getRows', $event)" class="form-control" :value="form.employee_id">
                               <option value="" selected disabled>{{ form.first_name}}</option>
                            </select>
                            <small class="error-control" v-if="errors.employee_id">
                                {{errors.employee_id[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Date</label>
                            <v-nepalidatepicker classValue="form-control" :value="form.date" @change="$emit('getFirstDate', $event)" v-model="form.date" placeholder="Date"/>
                            <small class="error-control" v-if="errors.date">
                                {{errors.date[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Salary (per month)</label>
                            <input type="number" class="form-control" v-model="form.salary" placeholder="Salary">
                            <small class="error-control" v-if="errors.salary">
                                {{errors.salary[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Bonus</label>
                            <input type="number" class="form-control" v-model="form.bonus" placeholder="Bonus">
                            <small class="error-control" v-if="errors.bonus">
                                {{errors.bonus[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Select Status</label>
                            <select name="status" id="" class="form-control" v-model="form.status">
                                <option value="" selected>Select Status</option>
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
                    <button class="btn btn-primary" :disabled="isProcessing" @click="onSave">Save</button>
                    <button class="btn" :disabled="isProcessing" @click="onCancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {get, byMethod } from '../../lib/api'
    
    export default{
        name: "EmployeePayroll",
        data(){
            return {
                form: {
                    bonus: 0,
                    date: ''
                },
                isProcessing: false,
                store: `/api/employees/`,
                method: 'POST',
                title: 'Payroll',
                resource: '/employees',
            }
        },
        mounted(){
            this.form.bonus = 0
        },
        created(){
            this.getCurrentDate()
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/employees/${to.params.id}/employee`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get(`/api/employees/${to.params.id}/employee`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            errors(){
                console.log('errors')
            },
            async getCurrentDate(){
                await get(`/api/employees/payroll/date`)
                .then((res) => {
                    console.log(res.data, this.form);
                    this.form.date = res.data
                })
            },
            setData(res) {
                Vue.set(this.$data, 'form', res.data.model)
                this.store = `/api/employees/${this.$route.params.id}/payroll`
                this.show = true
                this.$bar.finish()
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                let formData = new FormData();
                formData.append("employee_id", this.form.id)
                formData.append("salary", this.form.salary)
                formData.append("bonus", this.form.bonus)
                formData.append("date", this.form.date)
                formData.append("status", this.form.status)

                axios.post(this.store, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res) => {
                    console.log(res)
                    if(res.data.saved === true){
                        this.$toaster.success('Employee Payroll created Successfully!')
                        this.$router.push(`${this.resource}`)
                    }
                })
                .catch((error) => {
                    // error.response.status Check status code
                    if(error.response.status === 422) {
                        this.$toaster.warning('Please fill in the required fields!')
                        this.errors = error.response.data.errors
                    }
                    this.isProcessing = false
                }).finally(() => {
                    //Perform action in always
                });
            },
            onCancel() {
                if(this.$route.meta.mode === 'edit') {
                    this.$router.push(`${this.resource}/${this.form.id}/payroll`)
                } else {
                    this.$router.push(`${this.resource}`)
                }
            },
            success(res) {
                this.$router.push(`${this.resource}/${res.data.id}`)
            }
        }
    }
</script>