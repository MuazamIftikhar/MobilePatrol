<template>
    <div>
        <div>
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-title">
                                <h3 class="card-label">Schedule of <b class="text-primary">({{$route.params.name.replace('-',' ')}})</b></h3>
                            </div>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a :class="['nav-link', {'active':component_name == 'CalenderTable'}]" data-toggle="tab"
                                           href="#calender" @click="changeComponent('CalenderTable')">Calender</a>
                                    </li>
                                    <li class="nav-item">
                                        <a :class="['nav-link', {'active':component_name == 'AllSchedulesComponent'}]" data-toggle="tab" @click="changeComponent('AllSchedulesComponent')">Schedules</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="calender" role="tabpanel">
                                    <component :guards="guards" :time_zone="time_zone" :is="component_name"></component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!--end::Form-->
        </div>
    </div>
</template>

<script>
    import CalenderTable from './CalenderComponent.vue'
    import AllSchedulesComponent from './AllScheduleComponent.vue'
    export default {
        props:['guards','time_zone'],
        components:{CalenderTable,AllSchedulesComponent},
        data()
        {
            return{
                component_name:'CalenderTable',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        computed: {
        },
        methods:{
            changeComponent(name){
                this.component_name = name;
            }
        }
    }
</script>
