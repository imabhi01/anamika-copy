<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Add User</span>
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
                                Email
                            </label>
                            <input type="email" class="form-control" v-model="form.email" placeholder="Email">
                            <small class="error-control" v-if="errors.email">
                                {{errors.email[0]}}
                            </small>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label>
                                Password
                            </label>
                            <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                            <small class="error-control" v-if="errors.password">
                                {{errors.password[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" class="form-control" v-model="form.password_confirmation" placeholder="Password Confirmation">
                            <small class="error-control" v-if="errors.password_confirmation">
                                {{errors.password_confirmation[0]}}
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
                store: `/api/users/store`,
                resource: '/users',
                image: null,
                previewUrl: null
            }
        },
        methods:{
            errors(){
                console.log('here');
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
                
                formData.append("image", this.form.image);
                formData.append("first_name", this.form.first_name);
                formData.append("last_name", this.form.last_name);
                formData.append("email", this.form.email);
                formData.append("password", this.form.password);
                formData.append("password_confirmation", this.form.password_confirmation);

                axios.post(this.store, formData)
                .then((res) => {
                    if(res.data.saved === true){
                        this.$toaster.success('User Created Successfully!')
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

<style lang="scss" scoped>
    .preview{
        height: 100px;
    }
</style>