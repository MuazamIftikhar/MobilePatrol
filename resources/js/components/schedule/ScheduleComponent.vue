<template>
    <div>
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0  py-5">
                <h3 class="card-title font-weight-bolder">Clients</h3>
                <div class="card-toolbar">

                </div>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body p-5">
                <div>
                    <div class="input-group">
                        <input type="text" v-model="search" class="form-control" placeholder="Search for...">
                    </div>
                </div>
                <div style="max-height: 400px;overflow-y: scroll; margin-top: 10px">
                    <div style="cursor: pointer;" v-for="c in filteredAndSorted" :class="[{'selected_client':client_id == c.id}]" @click="open_tab(c.id,c.client_name.replace(' ','-'))">
                        <div class="d-flex align-items-center p-2">

                        <div class="symbol symbol-50 symbol-light mr-4">
                                <span class="symbol-label">
                                    <img src="/assets/media/svg/avatars/001-boy.svg" class="h-75 align-self-end" alt="">
                                </span>
                        </div>
                        <div>
                            <router-link :to="'/manager/schedule/'+c.id+'/'+c.client_name.replace(' ','-')"
                                         class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{c.client_name}}</router-link>
                            <span class="text-muted font-weight-bold d-block">{{c.client_address}}</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
            <!--end::Body-->
        </div>
    </div>
</template>

<script>
    export default {
        props:['clients'],
        data()
        {
            return{
                search:'',
                client_id:'',
            }
        },
        mounted() {
            console.log('Component mounted.')
            if(this.$route.params.id && this.$route.name == 'schedule-tab'){
                this.client_id = this.$route.params.id;
            }
        },
        computed: {
            filteredAndSorted(){
                // function to compare names
                function compare(a, b) {
                    if (a.client_name < b.client_name) return -1;
                    if (a.client_name > b.client_name) return 1;
                    return 0;
                }

                return this.clients.filter(user => {
                    return user.client_name.toLowerCase().includes(this.search.toLowerCase())
                }).sort(compare)
            }
        },
        methods:{
            open_tab(id,name){
                this.client_id = id;
                this.$router.push({ name: 'schedule-tab', params: { id: id,name:name } })
            }
        }
    }
</script>
<style>
    .selected_client{
        background-color: #f7f7f7;
    }
</style>
