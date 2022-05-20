<template>
    <div v-if="showSlider">
        <div id="kt_quick_user" :class="['offcanvas offcanvas-right p-10', {'offcanvas-on' :showSlider}] ">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0"><b>Schedule Information</b></h3>
                <a @click="closeSlider" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="offcanvas-content pr-5 mr-n5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="text-primary">Client Information</label><br>
                            <b>{{client.client_name}}</b><br>
                            <b>{{client.client_address}}</b>
                        </div>
                        <div class="form-group">
                            <label class="text-primary">Guard Information</label><br>
                            <b>{{guard.guard_name}}</b><br>
                            <b>{{guard.guard_phone}}</b>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>From Date time</label>
                            <datetime :zone="time_zone"  type="datetime" :min-datetime="min_date_time" format="yyyy-MM-dd HH:mm" v-model="from_date_time"></datetime>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>To Date time</label>
                            <datetime :zone="time_zone"  type="datetime" :min-datetime="min_date_time" format="yyyy-MM-dd HH:mm" v-model="to_date_time"></datetime>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Any Special instruction</label>
                            <textarea class="form-control" row="3" v-model="instructions"></textarea>
                        </div>
                    </div>
                </div>
                <button v-if="show_button" @click="saveSchedule" class="btn btn-primary btn-block">{{btn_text}}</button>
            </div>
            <!--end::Content-->

        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import HelperController from './../../controller/HelperController'
    export default {
        props:['showSlider','time_zone','view_schedule'],
        name:'ViewScheduleComponent',
        data() {
            return {
                days:[],
                from_date_time:new Date().toISOString(),
                to_date_time: new Date().toISOString(),
                date_limit: new Date().toISOString(),
                min_date_time:new Date().toISOString(),
                instructions:'',
                guard_id:'0',
                client:{},
                guard:{},
                saveScheduleButtonClicked:false,
                btn_text:'Update Schedule',
                show_button:true,
                id:'',
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            closeSlider(){
                this.$emit('closeSlider',false);
            },
            view_schedule_method(data,method){
                //console.log(JSON.stringify(data))
                if(method == 'action') {
                    this.from_date_time = data.iso_local_from_date_time;
                    this.to_date_time = data.iso_local_to_date_time;
                    this.instructions = data.instructions;
                    this.client = data.client;
                    this.guard = data.guards;
                    this.id = data.id;
                    this.show_button = moment(this.to_date_time).isAfter(moment())
                }else{
                    this.from_date_time = data.extendedProps.local_from_date_time;
                    this.to_date_time = data.extendedProps.local_to_date_time;
                    this.instructions = data.extendedProps.instructions;
                    this.client = data.extendedProps.client;
                    this.guard = data.extendedProps.guard;
                    this.id = data.id;
                    this.show_button = moment(this.to_date_time).isAfter(moment())
                }
            },
            saveSchedule(){
                console.log('from_time --' + this.from_date_time);
                if(!moment(this.to_date_time).isAfter(this.from_date_time)){
                    Vue.$toast.warning('Invalid Datetime Range: To Date time should be greater than From Date Time');
                    return false;
                }
                this.btn_text = 'Updating...';
//                Saving Schedule
                var params = {
                    from_date_time:this.from_date_time,
                    to_date_time:this.to_date_time,
                    guard_id:this.guard.id,
                    client_id:this.client.id,
                    instructions:this.instructions,
                    repeat:false,
                    id:this.id,
                }
                Promise.resolve(HelperController.sendPOSTRequest('update_schedule',params)).then( response => {
                    console.log('response+ '+JSON.stringify(response.data))
                    if(response.data.message == 'success'){
                        Vue.$toast.success(response.data.data.response);
                    }
                    if(response.data.message == 'warning'){
                        Vue.$toast.warning(response.data.data.response);
                    }

                }).catch(function(error){
                    console.log(error);
                });
                this.btn_text = 'Updated';
                setTimeout(function(){  this.btn_text = 'Update Schedule'; }, 1000);

            }
        }
    }
</script>

<style scoped="">
    label{
        margin-bottom: 0;
    }
</style>
