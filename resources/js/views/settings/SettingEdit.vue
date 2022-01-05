<template>
    <div>
         <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Edit Setting</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Project Title</label>
                            <input type="text" class="form-control" v-model="form.title" placeholder="Project Title">
                            <small class="error-control" v-if="errors.title">
                                {{errors.title[0]}}
                            </small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" v-model="form.description" placeholder="Description">
                            <small class="error-control" v-if="errors.description">
                                {{errors.description[0]}}
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

    export default {
        name: 'ItemEdit',
        data(){
            return {
                form: {},
                isProcessing: false,
                store: `/api/settings/`,
                method: 'PUT',
                title: 'Edit',
                resource: '/settings'
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/settings/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/settings/${to.params.id}`)
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
                this.store = `/api/settings/${this.$route.params.id}`
                this.show = true
                this.$bar.finish()
            },
            onSave() {
                this.errors = {}
                this.isProcessing = true

                byMethod(this.method, this.store, this.form)
                .then((res) => {
                    if(res.data && res.data.saved) {
                        this.$toaster.success('Setting Updated Successfully!')
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
                this.$router.push(`${this.resource}/${this.form.id}`)
            },
            success(res) {
                this.$router.push(`${this.resource}/${res.data.id}`)
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>