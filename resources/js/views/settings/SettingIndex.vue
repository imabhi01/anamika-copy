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
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in model.data" :key="item.data" @click="detailsPage(item)">
                            <td class="w-1 text-center">{{index+1}}</td>
                            <td class="w-3 text-center">{{item.title}}</td>
                            <td class="w-3 text-center">{{item.description}}</td>
                            <td class="w-3 text-center">
                                <router-link :to="`/settings/${item.id}`" class="btn">Show</router-link>
                            </td>
                        </tr>
                        <tr v-if="!model.data.length" class="text-center">
                            <td colspan = "100%" class="text-center">No Records Found</td>
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