<template> 
<div class="col-md-6 col-md-offset-3">
    <div class="alert alert-success alert-dismissible fade in" role="alert" v-bind:class="{ hidden: hasCreated }">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        Add Successfully!
    </div>

    <div class="x_panel">
        <div class="x_title">
            <h2><small>Crear Distribuidores</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        	<!-- start form for validation -->
            <form class="form-horizontal form-label-left" novalidate>
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">RUC <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="ruc" class="form-control col-md-7 col-xs-12" data-validate-length-range="11" name="ruc" equired="required" type="text" v-model="newItem.ruc">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Razón Social <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" v-model="newItem.name">
                    </div>
                </div>
                
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Dirección <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="address" type="text" name="address" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12" v-model="newItem.address">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Telefono <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" v-model="newItem.phone"> 
                    </div>
                </div>
                
                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button class="btn btn-primary" >Listar</button>
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
            newItem : {'ruc':'','name':'','address':'' ,'phone': ''},
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
            axios.get('/dealers').then(function (response) {
                that.items = response.data;

                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },


        createItem: function(){
            var input = this.newItem;
            if((input['name'] == '')||(input['ruc'] == '')){
                this.hasError = false;
                this.hasCreated = true;
            }
            else{
                this.hasError = true;
                axios.post('/dealers',input)
                .then(response => {
                    this.newItem = {'ruc':'','name':'','address':'' ,'phone': ''},
                    this.getVueItems();
                });
                this.hasCreated = false;
            }
        }
    }
}
</script>

