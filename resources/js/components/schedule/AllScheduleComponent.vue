<template>
    <div>
        <div id="app"  class="col-xs-12 col-lg-12 table-responsive">
            <div align="right" style="margin-bottom: 10px">
                <div class="form-inline margin-bottom-1 ">
                    <div class="form-group float-right">
                        <label for="filter" class="sr-only">Filter</label>
                        <input type="text" class="form-control myInput" id="myInput" v-model="filter"  @keydown="$event.stopImmediatePropagation()"  placeholder="Search Here..">
                    </div>
                </div>
            </div>
            <datatable  :columns="columns" :data="schedules" :filter="filter" :per-page="5" class="table-bordered table">

                <template slot-scope="{row,index}" >
                    <tr>
                        <td>{{row.guards.guard_name}}</td>
                        <td>{{row.only_date}}</td>
                        <td>{{row.iso_local_from_date_time | moment("ddd, MMM DD YYYY, h:mm a")}}</td>
                        <td>{{row.iso_local_to_date_time | moment("ddd, MMM DD YYYY, h:mm a")}}</td>
                        <td>{{row.only_hours}}</td>
                        <td>
                            <label v-if="row.status == 1" class="label label-warning label-lg label-inline">Ongoing</label>
                            <label v-if="row.status == 0" class="label label-default label-lg label-inline">Deleted</label>
                        </td>
                        <td>
                            <a @click="actions(row.id)" class="label label-primary label-lg label-inline">Action</a>
                        </td>
                    </tr>
                </template>

            </datatable>
            <div >
                <div class="form-inline float-right">
                    <bootstrap-4-datatable-pager type="abbreviated" v-model="page"></bootstrap-4-datatable-pager>
                </div>
            </div>
        </div>
        <component :showSlider="showSlider"
                   :time_zone="time_zone"
                   :view_schedule="view_schedule"
                   @closeSlider="closeSlider"
                   ref="view_schedule"
                   is="ViewScheduleComponent"
        ></component>
    </div>
</template>

<script>
    import moment from 'moment'
    import HelperController from './../../controller/HelperController'
    import ViewScheduleComponent from './ViewScheduleComponent.vue'
    export default {
        props:['time_zone'],
        name:'AllSchedulesComponent',
        components:{ViewScheduleComponent},
        data()
        {
            return{
                schedules:[],
                columns: [
                    // { label: 'ID',  filterable: true, field: 'emp.name' },
                    { label: 'Guard', field: 'guards.guard_name'},
                    { label: 'Date', field: 'only_date'},
                    { label: 'From Time', field: 'iso_local_from_date_time',filterable:true, },
                    { label: 'To Time', field: 'iso_local_to_date_time',filterable:true,interpolate:true},
                    { label: 'Hours', field: 'only_hours'},
                    { label: 'Status', field: 'status'},
                    { label: 'Action',sortable:false},

                ],
                rows: window.rows,
                page: 1,
                per_page: 10,
                filter: '',
                filterActivities: '',
                view_schedule:{},
                showSlider:false,
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.get_schedules_for_guard();
        },
        methods:{
            get_schedules_for_guard(){
                let self = this;
                var params = {
                    client_id : this.$route.params.id,
                }
                Promise.resolve(HelperController.sendPOSTRequest('get_schedules_for_guard',params)).then( response => {
                    self.schedules = response.data.data.schedules;
                }).catch(function(error){
                    console.log(error);
                });
            },
            actions(index){
                let self = this;
                self.showSlider = true;
                var schedule = self.schedules.filter(item => item.id == index);
                if(schedule.length > 0) {
                    self.view_schedule = schedule[0];
                    self.$refs.view_schedule.view_schedule_method(schedule[0], 'action');
                }
            },
            closeSlider(){
                this.showSlider = false;
            },
        }
    }
</script>
<style>
    .float-right{
        float: right !important;
    }
    th,tr{
        text-align: center !important;
    }
    .pagination {
        display: inline-block;
    }

    .pagination li {
        color: black;
        float: left;
        text-decoration: none;
        transition: background-color .3s;

    }
    .pagination>li>a, .pagination>li>span {
        position: relative;
        float: left;
        padding: 8px 12px;
        /* margin-left: -1px; */
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination li.active {
        background-color: #40CEE4;
        color: white;
        padding: 8px 16px;
        border: 1px solid #40CEE4;
    }

    .pagination li:hover:not(.active) {background-color: #ddd;}
    .pagination li.page-item {
        background-color: #fafafa;
        color: black;
        padding: 8px 16px;
        border: 1px solid #fafafa;
    }
    .pagination li.page-item.active {
        background-color: #40CEE4;
        color: white;
        padding: 8px 16px;
        border: 1px solid #40CEE4;
    }
</style>
