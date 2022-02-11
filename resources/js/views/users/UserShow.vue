<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{form.number}}</span>
                <div>
                    <router-link to="/users" class="btn">Back</router-link>
                    <router-link :to="`/users/${form.id}/edit`" class="btn">Edit</router-link>
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
                                Email
                            </label>
                            <input type="email" class="form-control" disabled v-model="form.email" placeholder="Email">
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
                            <input type="password" class="form-control" disabled v-model="form.password" placeholder="Password">
                            <small class="error-control" v-if="errors.password">
                                {{errors.password[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" class="form-control" disabled v-model="form.password_confirmation" placeholder="Password Confirmation">
                            <small class="error-control" v-if="errors.password_confirmation">
                                {{errors.password_confirmation[0]}}
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
        name: 'usershow',
        data(){
            return {
                form: {},
                errors: {}
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/users/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get(`/api/users/${to.params.id}`)
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
                byMethod('delete', `/api/users/${this.form.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/users')
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