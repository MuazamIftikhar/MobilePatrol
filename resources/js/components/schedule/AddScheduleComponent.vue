<template>
    <div class="card mb-10">
        <div class="card-header"><b>Create Schedule</b></div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>From Date time</label>
                        <datetime type="datetime" :min-datetime="min_date_time" format="yyyy-MM-dd HH:mm" v-model="from_date_time"></datetime>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>To Date time</label>
                        <datetime type="datetime" :min-datetime="min_date_time" format="yyyy-MM-dd HH:mm" v-model="to_date_time"></datetime>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Choose Guard</label>
                        <select class="form-control" v-model="guard_id">
                            <option value="0">--Select Guard--</option>
                            <option v-for="g in guards" :value="g.id">{{g.guard_name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Days</label>
                        <div class="checkbox-inline">
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Mon" v-model="days">Mon
                                <span></span></label>
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Tue" v-model="days">Tue
                                <span></span></label>
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Wed" v-model="days">Wed
                                <span></span></label>
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Thu" v-model="days">Thu
                                <span></span></label>
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Fri" v-model="days">Fri
                                <span></span></label>
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Sat" v-model="days">Sat
                                <span></span></label>
                            <label class="checkbox checkbox-primary">
                                <input type="checkbox" name="days[]" value="Sun" v-model="days">Sun
                                <span></span></label>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4" v-if="days && days.length > 1">
                    <div class="form-group">
                        <label>End Date</label>
                        <datetime v-model="date_limit" format="yyyy-MM-dd" type="date"></datetime>
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
            <div class="row">
                <div class="col-lg-6" v-for="err in error_array">
                    <b class="text-danger">{{err}}</b>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button @click="saveSchedule" class="btn btn-primary">{{btn_text}}</button>
        </div>
    </div>
</template>

<script>
    import HelperController from './../../controller/HelperController'
    export default {
        props:['guards'],
        name:'AddScheduleComponent',
        data()
        {
            return{
                saveScheduleButtonClicked:false,
                btn_text:'Save Schedule',
                days:[],
                from_date_time:new Date().toISOString(),
                to_date_time: new Date().toISOString(),
                date_limit: new Date().toISOString(),
                min_date_time:new Date().toISOString(),
                instructions:'',
                guard_id:'0',
                error_array:[]
            }
        },
        watch:{
            from_date_time(val){
                var dayName = moment(val).format('ddd');
                this.days = [];
                if(!this.days.includes(dayName)){
                    this.days.push(dayName)
                }
            }
        },
        mounted() {
            console.log('Component mounted.' + new Date().toISOString())
            var dt = new Date();
            dt.setHours( dt.getHours() + 6 );
            this.to_date_time = dt.toISOString();
            //Pusing Day Name into Days Array selected
            this.days.push(moment(this.from_date_time).format('ddd'))
        },
        methods:{
            saveSchedule(){
                if(!moment(this.to_date_time).isAfter(this.from_date_time)){
                    Vue.$toast.warning('Invalid Datetime Range: To Date time should be greater than From Date Time');
                    return false;
                }
                if(this.guard_id == '0'){
                    Vue.$toast.warning('Please choose a Guard');
                    return false;
                }
                this.btn_text = 'Creating...';
//                Saving Schedule
                var params = {
                    from_date_time:this.from_date_time,
                    to_date_time:this.to_date_time,
                    guard_id:this.guard_id,
                    client_id:this.$route.params.id,
                    instructions:this.instructions,
                    days:this.days,
                    repeat:this.days.length > 1 ? true : false,
                    date_limit:this.date_limit
                }
                Promise.resolve(HelperController.sendPOSTRequest('save_schedule',params)).then( response => {
                    console.log('response+ '+JSON.stringify(response.data))
                    if(response.data.message == 'success' && this.days.length == 1){
                        Vue.$toast.success(response.data.data.response);
                    }
                    if(response.data.message == 'warning' && this.days.length == 1){
                        Vue.$toast.warning(response.data.data.response);
                    }
                    if(response.data.message == 'success' && this.days.length > 1){
                        Vue.$toast.success(response.data.data.response);
                        if(response.data.data.issues.length > 0){
                            this.error_array = response.data.data.issues;
                            Vue.$toast.warning('Some shifts cannot be created. They are explained below');
                        }
                    }

                    this.$emit('methodcreateScheduleButtonClicked')

                }).catch(function(error){
                    console.log(error);
                });
                this.btn_text = 'Created';
                setTimeout(function(){  this.btn_text = 'Created Schedule'; }, 1000);
            }
        }
    }
</script>
<style>

    .vue__time-picker input.display-time, .vdatetime-input {
        width: 100% !important;
        height: calc(1.5em + 1.3rem + 2px);
        padding: 0.65rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #464E5F;
        background-color: #ffffff;
        background-clip: padding-box;
        border: 1px solid #E5EAEE;
        border-radius: 0.42rem;
        box-shadow: none;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
</style>
