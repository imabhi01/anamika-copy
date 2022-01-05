<template>
    <div>
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Settings</span>
                <div>
                    <router-link v-if="model.data.length == 0" :to="{name: 'settings-create'}" class="btn btn-primary">
                        Create Setting
                    </router-link>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-link">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                            <td class="w-1">{{item.id}}</td>
                            <td class="w-3">{{item.title}}</td>
                            <td class="w-3">{{item.description}}</td>
                            <td class="w-3">
                                <router-link :to="`/settings/${item.id}`" class="btn">Show</router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import {get} from '../../lib/api'
    import search from '../../components/layouts/search'

    export default {
        name: 'ItemIndex',
        components:{
            search
        },
        data(){
            return {
                model: {
                    data: []
                }
            }
        },
        beforeRouteEnter (to, from, next) {
            get('/api/settings', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/settings', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res){
                this.model = res.data.results
                this.$bar.finish()
            },
            detailsPage(item){
                this.$router.push(`/settings/${item.id}`)
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>