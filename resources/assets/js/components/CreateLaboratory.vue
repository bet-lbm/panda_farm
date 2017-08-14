<template> 
<div class="col-md-8 col-md-offset-1">
    <div class="alert alert-success alert-dismissible fade in" role="alert" v-bind:class="{ hidden: hasCreated }">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        Add Successfully!
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2><small>Crear Laboratorio</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        	<!-- start form for validation -->
            <form class="form-horizontal form-label-left" novalidate>
               
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">Nombre <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name"  required="required" type="text" v-model="newItem.name">
                        </div>
                    </div>
             
                
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-5 col-xs-12" for="health_code">Codigo Sanitario<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-7 col-xs-12">
                            <input id="health_code" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="health_code"  required="required" type="text" v-model="newItem.health_code">
                        </div>
                    </div>
                
                
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-5 col-xs-12" for="authorization">Codigo Autorizacion <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-7 col-xs-12">
                            <input id="authorization" type="text" name="authorization" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12" v-model="newItem.authorization">
                        </div>
                    </div>
               
                
                    <div class="item form-group">
                        <label class="control-label col-md-4 col-sm-5 col-xs-12" for="phone">Telefono <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-7 col-xs-12">
                            <input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" v-model="newItem.phone"> 
                        </div>
                    </div>
                
                <div class="ln_solid"></div>
                    <div class="form-group text-center">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <button class="btn btn-primary" >Listar</button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 center">
                             <button class="btn btn-success" @click.prevent="createItem()">Submit</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){ 
        return{
            items: [],
            newItem : {'name':'','health_code':'','authorization':'' ,'phone': ''},
            hasError: true,
            hasCreated: true,
            formErrors: {},
            formErrorsUpdate: {},
        }
    },

    mounted() {
        this.getVueItems();
    },
    methods : {

        getVueItems: function(){
            var that = this;
            axios.get('/laboratories').then(function (response) {
                that.items = response.data;

                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },


        createItem: function(){
            var input = this.newItem;
            if((input['name'] == '')||(input['health_code']=='')){
                this.hasError = false;
                this.hasCreated = true;
            }
            else{
                this.hasError = true;
                axios.post('/laboratories',input)
                .then(response => {
                    this.newItem = {'name':'','health_code':'','authorization':'' ,'phone': ''},
                    this.getVueItems();
                    toastr.success('Laboratorio creado', {timeOut: 5000});
                });
                this.hasCreated = false;
            }
        }
    }
}
</script>
