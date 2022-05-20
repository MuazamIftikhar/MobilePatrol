<template>
    <div class="row ">
        <div class="col-8 p-5" style="background-color: white" >
            <!--<h3>Create Form</h3>-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Form Name</label>
                        <input type="text" v-model="form_name" class="form-control"/>
                        <span v-show="errors.form_name"
                              class="help-block">Please enter a form name</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Form Description</label>
                        <input type="text" v-model="description" class="form-control"/>
                        <span v-show="errors.description"
                              class="help-block">Please enter a description</span>
                    </div>
                </div>
            </div>

            <label>Dynamic Form</label>
            <draggable class="dragArea list-group" :list="form_element_list" group="people"
                       style="background-color: gainsboro; padding: 20px" @change="log">

                <div v-if="form_element_list == ''">
                    <p>Drag over here</p>
                </div>
                <div v-else="this" class="list-group-item mb-2" v-for="(element, idx) in form_element_list" :key="element.name">
                    <div class="row">
                        <div class="col-md-11" v-if="element.name == 'text'">
                            <label>{{element.label}}</label>
                            <input type="text" class="form-control" :placeholder="element.placeholder" />
                        </div>
                        <div class="col-md-11" v-if="element.name == 'number'">
                            <label>{{element.label}}</label>
                            <input class="form-control" type="number" placeholder="Enter Number">
                        </div>
                        <div class="col-md-11" v-if="element.name == 'date'">
                            <label>{{element.label}}</label>
                            <input class="form-control" type="date" placeholder="Enter Date">
                        </div>
                        <div class="col-md-11" v-if="element.name == 'file'">
                            <label>{{element.label}}</label>
                            <input class="form-control" type="file" placeholder="Enter File">
                        </div>
                        <div class="col-md-11" v-if="element.name == 'textarea'">
                            <label>{{element.label}}</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="col-md-11" v-if="element.name == 'radio'">
                            <div class="form-group">
                                <label>{{element.label}}</label>
                                <div class="radio-inline">
                                    <label class="radio" v-for="option in  element.option">
                                        <input type="radio" name="gender">{{option.name}}
                                        <span></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11" v-if="element.name == 'select'">
                            <div class="form-group">
                                <label>{{element.label}}</label>
                                <select class="form-control"  id="exampleSelect1">
                                    <option v-for="option in  element.option">{{option.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 ">
                            <i class="fa fa-pencil-alt mt-12" @click="editAt(idx) "></i>
                            &nbsp; &nbsp;
                            <i class="fa fa-times mt-9" @click="removeAt(idx)"></i>
                        </div>
                    </div>
                </div>
            </draggable>
            <span v-show="errors.form_element"
                  class="help-block">Please add atleast one element</span>
            <button class="btn btn-success mt-5" @click="updated_at"> Update Form</button>
        </div>
        <div class="col-4">
            <h3>Elements</h3>
            <draggable class="dragArea list-group" :list="element_list" :group="{ name: 'people', pull: 'clone', put: false }"
                       style="background-color: gainsboro; padding: 20px" @change="log">
                <div class="list-group-item mb-2" v-for="element in element_list" :key="element.name">
                    {{ element.name }}
                </div>
            </draggable>
        </div>

        <EditElementComponent @closeSlider="closeSlider" ref="edit_element" :showSlider="showSlider" @editElement="editElement"></EditElementComponent>
    </div>
</template>

<script>
    import draggable from "vuedraggable";
    import EditElementComponent from "./EditElementComponent.vue";
    import HelperController from './../../controller/HelperController';

    export default {
        name: "clone",
        display: "Clone",
        order: 2,
        components: {
            draggable , EditElementComponent
        },
        data() {
            return {
                form_name : '',
                description : '',
                id : '',
                errors : {form_name:false,description:false,form_element:false},
                showSlider:false,
                element_list: [
                    {name: "text", id: 1, label : "Enter Text" , required : "true" , placeholder : "Enter Text" },
                    {name: "number", id: 2, label : "Enter Number" , required : "true" , placeholder : "Enter Number"},
                    {name: "date", id: 3 ,label : "Enter Date" , required : "true" , placeholder : "Enter Date"},
                    {name: "radio", id: 4 ,label : "Enter Text" , required : "true" , placeholder : "Enter Text" , option :[ {id :1 ,name: "option 1" },{id :2 , name: "option 2" }]},
//                    {name: "select", id: 5 ,label : "Enter Text" , required : "true" , placeholder : "Enter Text" , option :[ {id :1 ,name: "option 1" },{id :2 , name: "option 2" }]},
//                    {name: "file", id: 6 ,label : "Enter file" , required : "true" , placeholder : "Enter file"},
                    {name: "textarea", id: 7 ,label : "Enter text" , required : "true" , placeholder : "Enter text"},
                ],
                form_element_list: [],
                form_elements: []
            };
        },
        mounted(){
            let self=this;
            self.get_value();
        },
        methods: {
            get_value(){
                let self=this;
                let id=self.$route.params.id

                Promise.resolve(HelperController.sendGetRequest('manager/get/form/'+id)).then( response => {
                    if(response.data != ''){
                        self.form_name=response.data.name;
                        self.description=response.data.description;
                        self.id=response.data.id;
                        self.form_element_list=JSON.parse(response.data.form_element);
                    }
                    if(response.data.message == 'warning'){
                        Vue.$toast.warning(response.data.data.response);
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            updated_at(){
                let self=this;
                if (self.form_name.trim() == ''){self.errors.form_name = true;return false;}else {self.errors.form_name = false}
                if (self.description.trim() == ''){self.errors.description = true;return false;}else {self.errors.description = false}
                if (self.form_element_list.length == '0'){self.errors.form_element = true;return false;}else {self.errors.form_element = false}

                for( var j = 0; j < this.form_element_list.length; j++ ){
                    let object = self.form_element_list[j];
                    self.form_elements.push(JSON.stringify(object));
                }
                console.log(self.form_elements);

                var params = {
                    form_name:self.form_name,
                    description:self.description,
                    form_element:self.form_elements,
                    id:self.id,
                }
                console.log(params);
                Promise.resolve(HelperController.sendPOSTRequest('update_form',params)).then( response => {

                    if(response.data.message == 'success'){
                        Vue.$toast.success(response.data.data.response);
                    }
                    if(response.data.message == 'warning'){
                        Vue.$toast.warning(response.data.data.response);
                    }

                }).catch(function(error){
                    console.log(error);
                });



            },
            removeAt(idx) {
                let self = this;
                self.form_element_list.splice(idx, 1);
            },
            editElement(data){
                var index_id = data.id;
                var form_element_list = this.form_element_list[index_id];
                form_element_list.label = data.label;
                form_element_list.placeholder = data.placeholder;
                form_element_list.required = data.required;
                console.log('child data',data);
            },
            editAt(idx) {
                let self = this;
                self.showSlider = true;
                var object = self.form_element_list[idx];
                console.log(object);
                self.$refs.edit_element.view_edit_element(object ,idx);
            },
            closeSlider(){
                this.showSlider = false;
            },
            log: function (evt) {
                window.console.log(evt);
            }
        }
    };
</script>
<style scoped>
    .help-block{
        color:red !important;
        text-align: left !important;
    }
</style>