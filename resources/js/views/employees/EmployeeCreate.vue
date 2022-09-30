<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Add Employee</span>
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
                            <input type="text" class="form-control" v-model="form.phone" placeholder="Phone Number">
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
                            <label>Joining Date</label>
                            <v-nepalidatepicker classValue="form-control" v-model="form.joining_date" calenderType="Nepali" :monthSelect="false" :yearSelect="false"/>
                            <small class="error-control" v-if="errors.joining_date">
                                {{errors.joining_date[0]}}
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
                            <label>Image</label>
                            <input type="file" accept="image/*" @change="selectImage($event)" id="file-input">
                            <div v-if="previewUrl" class="mt-3">
                                <img :src="previewUrl" class="figure-img img-fluid img-rounded preview" alt="">
                            </div>
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
        data(){
            return {
                form: {},
                isProcessing: false,
                store: `/api/employees/store`,
                resource: '/employees',
                image: null,
                previewUrl: null
            }
        },
        methods:{
            errors(){
            },
            selectImage(e){
                this.image = e.target.files[0]
                this.previewUrl = URL.createObjectURL(this.image)
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true
                this.form.image = this.image
                
                let formData = new FormData();
                
                formData.append("first_name", this.form.first_name);
                formData.append("last_name", this.form.last_name);
                formData.append("phone", this.form.phone);
                formData.append("salary", this.form.salary);
                formData.append("address", this.form.address);
                formData.append("joining_date", this.form.joining_date);
                formData.append("image", this.form.image);

                axios.post(this.store, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res) => {
                    if(res.data.saved === true){
                        this.$toaster.success('Employee Created Successfully!')
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
                this.$router.push(`${this.resource}`)
            }
        }
    }
</script>