<template>
    <div>
        <div class="row" style="margin-left: 0px; justify-content: space-between;">
            <div class="form-group">
                <label for="show">Show rows</label>
                <!-- <select name="number_of_rows" id="select-rows" @change="$emit('getRows', $event)" class="form-control" :value="total_rows"> -->
                <select name="number_of_rows" id="select-rows" @change="$emit('filterMethod', {event: $event, name: 'total_rows'})" class="form-control" :value="total_rows">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
            </div>

            <div class="form-group">
                <label for="show">Status</label>
                <select name="status" id="status" @change="$emit('filterMethod', {event: $event, name: 'status'})" class="form-control" :value="status">
                    <option value="" disabled selected>Select Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Un paid">Un Paid</option>
                </select>
            </div>

            <div class="form-group">
                <label>First Date :</label>
                <v-nepalidatepicker classValue="form-control" :value="firstDate" @change="$emit('getFirstDate', $event)" v-model="first_date" placeholder="First Date" calenderType="Nepali" :monthSelect="false" :yearSelect="false"/>
            </div>

            <div class="form-group">
                <label>Second Date :</label>
                <v-nepalidatepicker classValue="form-control" :value="secondDate" @change="$emit('getSecondDate', $event)" v-model="second_date" placeholder="Second Date" calenderType="Nepali" :monthSelect="false" :yearSelect="false"/>
            </div>

            <div class="form-group">
                <label for="search-between">Search Date</label>
                <button class="btn btn-primary" @click="searchDate"><i class="fa fa-search" aria-hidden="true"></i> Search Date</button>
            </div>

            <div class="form-group">
                <label for="search-between">Reset Filter</label>
                <button class="btn btn-primary" @click="resetFilter"> <i class="fa fa-refresh" aria-hidden="true"></i> Reset Filter</button>
            </div>
            
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="search">Search</label>
                    <input type="search" name="search" v-model.lazy="search" @keyup="$emit('filterMethod', {event: $event, name: 'search'})" class="form-control" placeholder="Search by name, phone...">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SalesSearch',
        props: ['total_rows', 'search', 'first_date', 'second_date', 'status'],
        data(){
            return {
                firstDate: this.firstDate,
                secondDate: this.second_date
            }
        },
        methods:{
            searchDate(){
                this.$emit('filterMethod', {event: [this.first_date, this.second_date], name: 'search-date'});
            },
            resetFilter(){
                this.$emit('filterMethod', {name: 'reset-data'});
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>