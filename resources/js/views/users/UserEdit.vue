<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Edit User</span>
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
        name: 'UserEdit',
        data(){
            return {
                form: {},
                isProcessing: false,
                store: `/api/users/`,
                method: 'PUT',
                title: 'Edit',
                resource: '/users',
                previewUrl: null,
                image: null
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/users/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/users/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            errors(){
                console.log('errors')
            },
            selectImage(e){
                this.image = e.target.files[0]
                this.previewUrl = URL.createObjectURL(this.image)
            },
            setData(res) {
                Vue.set(this.$data, 'form', res.data.model)
                this.store = `/api/users/${this.$route.params.id}`
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
                formData.append("email", this.form.email);
                formData.append("password", this.form.password);
                formData.append("password_confirmation", this.form.password_confirmation);
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