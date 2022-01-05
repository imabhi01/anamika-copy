<template>
    <div>
        <div class="panel" v-if="show">
            <div class="panel-heading">
                <span class="panel-title">{{model.id}}</span>
                <div>
                    <router-link to="/settings" class="btn">Back</router-link>
                    <router-link :to="`/settings/${model.id}/edit`" class="btn">Edit</router-link>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <p>{{ model.title }}</p>|
                    <p>{{ model.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {get, byMethod} from '../../lib/api'

    export default {
        name: 'settingshow',
        data(){
            return {
                show:false,
                model: {
                    item: {}
                }
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
            setData(res) {
                Vue.set(this.$data, 'model', res.data.model)
                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/settings/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/settings')
                        }
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>