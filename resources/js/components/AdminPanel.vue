<template>
    <div>
        <!-- Page Wrapper -->
        <div id="wrapper" v-if="isLoggedIn">

            <Sidebar />

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <TopBar />

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <router-view></router-view>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

            <Footer :year="year"/>
            </div>
            <!-- End of Content Wrapper -->
        </div>

        <div id="wrapper" v-if="!isLoggedIn">
            <p>You're not logged in!</p>
        </div>
    </div>
</template>

<script>
    import TopBar from '../components/layouts/TopBar.vue'
    import Sidebar from '../components/layouts/Sidebar.vue'
    import Footer from '../components/layouts/Footer.vue'
    import {mapGetters} from 'vuex'

    export default {
        name: 'AdminPanel',
        components:{
            TopBar,
            Sidebar,
            Footer
        },
        async mounted(){
            this.$store.dispatch('getSetting')
        },
        computed: {
            ...mapGetters(['isLoggedIn', 'setting'])
        },
        data(){
            return {
                year: new Date().getFullYear()
            }
        }
    }
</script>

<style lang="scss" scoped>
</style>