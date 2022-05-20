<template>
    <div v-if="showSlider">
        <div id="kt_quick_user" :class="['offcanvas offcanvas-right p-10', {'offcanvas-on' :showSlider}] ">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0"><b>Edit Element</b></h3>
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
                            <!--<label class="text-primary">Element</label><br>-->
                        </div>
                        <div class="form-group">
                            <label class="text-primary">Element Label</label><br>
                            <input type="text" v-model="label" class="form-control" />
                        </div>
                            <br>
                        <div class="form-group">
                            <label class="text-primary">Element Placeholder</label><br>
                            <input type="text" v-model="placeholder" class="form-control" />
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="text-primary">Element Required</label><br>
                            <span class="switch switch-brand"> <label>
                                <input type="checkbox" v-model="required" @change="checked_false" :checked="required == 'true' ? 'checked' : ''" name="select"/>
                                <span></span></label></span>
                        </div>
                        <br>
                        <div class="form-group" v-if="name == 'radio' || name == 'select' ">
                            <label class="text-primary">Element Options</label><br>
                            <div class="form-group"  v-for="elementOption in option">
                                <input type="text" v-model="elementOption.name" class="form-control" />
                            </div>
                            <div id="append_input">
                            </div>
                            <button type="button" class="btn btn-success" @click="add_imput">Add Option</button>
                        </div>
                        <br>
                            <button type="button" class="btn btn-success" @click="send_updated_data_to_parent">Update</button>

                    </div>

                </div>
            </div>
            <!--end::Content-->
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import HelperController from './../../controller/HelperController'
    export default {
        props:['showSlider'],
        name:'EditElementComponent',
        data() {
            return {
                name : '',
                label : '',
                placeholder : '',
                required : '',
                option : [],
                id:'',
            }
        },
        mounted() {
           // console.log(showSllider);
        },
        methods:{
            checked_false(){
              this.required = false;
            },
            closeSlider(){
                this.$emit('closeSlider',false);
            },
            view_edit_element(data,idx){
                this.name = data.name;
                this.label = data.label;
                this.placeholder = data.placeholder;
                this.required = data.required;
                this.option = data.option;
                this.id = idx;
            },
            send_updated_data_to_parent(){
                var data = {
                    label: this.label,
                    placeholder: this.placeholder,
                    required: this.required,
                    id: this.id,
                }
                this.$emit('editElement',data);
                this.$emit('closeSlider',false);

            },
            add_imput(){
                let value=this.option[this.option.length - 1].id;
                let add_value=value+1;
                this.option.push({ id : add_value , name : "option "+add_value });
            }
        }
    }
</script>

<style scoped="">
    label{
        margin-bottom: 0;
    }
</style>
