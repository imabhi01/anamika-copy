<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Edit Payroll</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="show">Employee</label>
                            <select class="form-control" v-model="form.employee.first_name">
                               <option disabled>{{ form.employee.first_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Date</label>
                            <v-nepalidatepicker classValue="form-control" :value="form.date" @change="$emit('getFirstDate', $event)" v-model="form.date" placeholder="Date" calenderType="Nepali" :monthSelect="false" :yearSelect="false"/>
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
                            <label>Advance</label>
                            <input type="number" class="form-control" v-model="form.advance" placeholder="Advance">
                            <small class="error-control" v-if="errors.advance">
                                {{errors.advance[0]}}
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
                    <button class="btn btn-primary"  @click="onSave">Save</button>
                    <button class="btn" :disabled="isProcessing" @click="onCancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {get, byMethod } from '../../lib/api'
    export default {
        name: 'EmployeeEdit',
        data(){
            return {
                form: {},
                isProcessing: false,
                store: `/api/payroll/`,
                title: 'Edit',
                resource: '/payroll'
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/payroll/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/payroll/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            errors(){
                console.log('errors')
            },
            setData(res) {
                Vue.set(this.$data, 'form', res.data.model)
                this.store = `/api/payroll/${this.$route.params.id}`
                this.show = true
                this.$bar.finish()
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                
                let formData = new FormData();
                formData.append("employee_id", this.form.employee_id);
                formData.append("salary", this.form.salary);
                formData.append("bonus", this.form.bonus);
                formData.append("advance", this.form.advance);
                formData.append("date", this.form.date);
                formData.append("status", this.form.status);

                axios.post(this.store, formData)
                .then((res) => {
                    console.log(res);
                    if(res.data && res.data.saved) {
                        this.$toaster.success('Payroll Updated Successfully!')
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
            onCancel() {
                this.$router.push(`${this.resource}/${this.form.id}/show`)
            },
            success(res) {
                this.$router.push(`${this.resource}/${this.form.id}/show`)
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