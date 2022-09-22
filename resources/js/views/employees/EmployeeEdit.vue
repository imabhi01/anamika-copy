<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Edit Employee</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" v-model="form.first_name" placeholder="First Name">
                            <small class="error-control" v-if="errors.first_name">
                                {{errors.first_name[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" v-model="form.last_name" placeholder="Last Name">
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
                            <input type="text" class="form-control" v-model="form.phone" placeholder="Phone">
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
                            <input type="text" class="form-control" v-model="form.address" placeholder="Address">
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
                            <input type="date" class="form-control" v-model="form.joining_date" placeholder="Joining Date">
                            <small class="error-control" v-if="errors.joining_date">
                                {{errors.joining_date[0]}}
                            </small>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" class="form-control" v-model="form.salary" placeholder="Salary">
                            <small class="error-control" v-if="errors.salary">
                                {{errors.salary[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" accept="image/*" @change="selectImage($event)" id="file-input">
                            <div class="mt-3">
                                <img v-if="previewUrl" :src="previewUrl" class="figure-img img-fluid img-rounded preview" alt="">
                                <img v-if="!previewUrl" :src="form.image" class="figure-img img-fluid img-rounded preview" alt="">
                            </div>
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
                store: `/api/employees/`,
                method: 'PUT',
                title: 'Edit',
                resource: '/employees',
                previewUrl: null,
                image: null
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/employees/${to.params.id}`)
                .then((res) => { console.log('here');
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/employees/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            mounted(){
                console.log(this.form)
                alert('here');
            },
            errors(){
                console.log('errors')
            },
            selectImage(e){
                this.image = e.target.files[0]
                this.previewUrl = URL.createObjectURL(this.image)
            },
            setData(res) {
                Vue.set(this.$data, 'form', res.data.model)
                console.log(this.$data);
                this.store = `/api/employees/${this.$route.params.id}`
                this.show = true
                this.$bar.finish()
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                this.form.image = this.image
                let formData = new FormData();
                formData.append("image", this.form.image);
                formData.append("first_name", this.form.first_name);
                formData.append("last_name", this.form.last_name);
                formData.append("phone", this.form.phone);
                formData.append("address", this.form.address);
                formData.append("joining_date", this.form.joining_date);
                formData.append("salary", this.form.salary);
                console.log(formData);
                byMethod(this.method, this.store, formData)
                .then((res) => {
                    if(res.data && res.data.saved) {
                        this.$toaster.success('User Updated Successfully!')
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
                if(this.$route.meta.mode === 'edit') {
                    this.$router.push(`${this.resource}/${this.form.id}`)
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