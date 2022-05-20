<template>
    <div>
        <div class="row">
            <div class="col-lg-12 mb-5">
                <div class="float-right">
                    <button :class="['btn', {'btn-primary':createScheduleButtonClicked == false,'btn-warning': createScheduleButtonClicked}]" @click="toggleScheduleForm">{{toggle_button_text}}</button>
                </div>
            </div>
            <div class="col-lg-12">
                <div>
                    <AddScheduleComponent @methodcreateScheduleButtonClicked="methodcreateScheduleButtonClicked" v-if="createScheduleButtonClicked" :guards="guards"/>
                </div>
            </div>
            <div class="col-lg-12">
                <div class='demo-app-main'>
                    <FullCalendar
                            ref="calender"
                            class='fc-content'
                            :options='calendarOptions'
                    >
                        <template v-slot:eventContent="arg">
                            <div class="fc-content">
                                <div class="fc-title">{{ arg.event.title}}</div>

                            </div>
                        </template>
                    </FullCalendar>
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
    import AddScheduleComponent from './AddScheduleComponent.vue'
    import ViewScheduleComponent from './ViewScheduleComponent.vue'
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import moment from 'moment'
    import HelperController from './../../controller/HelperController'
    export default {
        props:['guards','time_zone'],
        name:'CalenderTable',
        components:{AddScheduleComponent,FullCalendar,ViewScheduleComponent},
        data()
        {
            return{
                createScheduleButtonClicked:false,
                toggle_button_text:'Show Create Schedule',
                calendarOptions: {
                    plugins: [
                        dayGridPlugin,
                        timeGridPlugin,
                        interactionPlugin // needed for dateClick
                    ],
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    initialView: 'dayGridMonth',
                    editable: true,
                    selectable: true,
                    selectMirror: true,
                    dayMaxEvents: true,
                    weekends: true,
                    select: this.handleDateSelect,
                    eventClick: this.handleEventClick,
                    eventsSet: this.handleEvents,
                    datesSet: this.handleMonthChange,
                    initialEvents: [],
                    events:[],
                    /* you can update a remote database when these fire:
                    eventAdd:
                    eventChange:
                    eventRemove:
                    */

                },
                showSlider:false,
                view_schedule:{}
            }
        },
        mounted() {
            console.log('Component mounted.')
            var month = moment().format("MM")
            this.get_schedules_for_guard(month)
        },
        methods:{
            toggleScheduleForm(){
                this.createScheduleButtonClicked = !this.createScheduleButtonClicked;
                if(this.createScheduleButtonClicked == true){
                    this.toggle_button_text = 'Hide Create Schedule'
                }else{
                    this.toggle_button_text = 'Show Create Schedule'
                }
            },
            handleEventClick(clickInfo) {
                let self = this;
                self.showSlider = true;
                console.log('EVENT - '+JSON.stringify(clickInfo.event))
                self.view_schedule = clickInfo.event;
                self.$refs.view_schedule.view_schedule_method(clickInfo.event,'calender');
            },
            get_schedules_for_guard(month){
                console.log("Month "+ month);
                let self = this;
                self.calendarOptions.events = [];
                var params = {
                    client_id : this.$route.params.id,
                    month:month
                }
                Promise.resolve(HelperController.sendPOSTRequest('get_schedules_for_guard',params)).then( response => {
                    for(var x of response.data.data.schedules){
                        console.log('ID  + '+x.id);
                        self.calendarOptions.events.push({id:x.id,
                            title:x.title,
                            start:x.start,
                            end:x.end,
                            className:x.class_name,
                            instructions:x.instructions,
                            client:x.client,
                            guard:x.guards,
                        local_from_date_time:x.iso_local_from_date_time,
                            local_to_date_time:x.iso_local_to_date_time});
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            async handleMonthChange(payload) {
                console.log('handleMonth change has been been');
                //console.log(payload);
            },
            closeSlider(){
                this.showSlider = false;
            },
            methodcreateScheduleButtonClicked(){
                this.createScheduleButtonClicked = false;
                this.toggle_button_text = 'Show Create Schedule'
                var month = moment().format("MM")
                this.get_schedules_for_guard(month)
            }
        }
    }
</script>
<style>
    .fc-event {
        position: relative;
        display: block;
        font-size: 0.85em;
        line-height: 1.4;
        border-radius: 3px;
        border: none !important;
    }

    .fc-event, .fc-event-dot {
        background-color: transparent !important;
    }

    .fc-event-primary {
        background-color: #3699FF !important;
        padding: 5px;
        color: white !important;
        -webkit-box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        border-radius: 5px;
    }

    .fc-event-success {
        background-color: #1BC5BD !important;
        padding: 5px;
        color: white !important;
        -webkit-box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        border-radius: 5px;
    }

    .fc-event-danger {
        background-color: #EE2D41 !important;
        padding: 5px;
        color: white !important;
        -webkit-box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        border-radius: 5px;
    }

    .fc-event-warning {
        background-color: #FFA800 !important;
        padding: 5px;
        color: white !important;
        -webkit-box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        box-shadow: 0px 0px 9px 0px rgb(0 0 0 / 6%);
        border-radius: 5px;
    }
    .fc-button-primary{
        color: #FFFFFF !important;
        background-color: #3699FF !important;
        border-color: #3699FF !important;
    }
</style>
