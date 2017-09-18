<template> 
<div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
    <div class="x_panel">
        <div class="x_title">
            <h5>Crear nuevo cliente</h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        	<!-- start form for validation -->
            <form class="form-horizontal form-label-left" novalidate>
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-5 col-xs-6" for="dni">DNI <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <input id="dni" class="form-control col-md-7 col-xs-6" data-validate-length-range="8" name="dni" required="required" type="text" v-model="newItem.dni">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-5 col-xs-6" for="name">Nombre <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <input id="name" class="form-control col-md-7 col-xs-6" data-validate-length-range="6" data-validate-words="2" name="name"  required="required" type="text" v-model="newItem.name">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-5 col-xs-6" for="last_name">Apellidos<span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <input id="last_name" class="form-control col-md-7 col-xs-6" data-validate-length-range="6" data-validate-words="2" name="last_name"  required="required" type="text" v-model="newItem.last_name">
                    </div>
                </div>
                
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-5 col-xs-6" for="address">Dirección <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <input id="address" type="text" name="address" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12" v-model="newItem.address">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-5 col-xs-6" for="phone">Teléfono <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-6">
                        <input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" v-model="newItem.phone"> 
                    </div>
                </div>
                
                <div class="ln_solid"></div>

                <div class="form-group text-center">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <button class="btn btn-primary" >Listar</button>
                       
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <button class="btn btn-success" @click.prevent="createItem()">Guardar Cliente</button>
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
            newItem : {'dni':'','name':'','last_name':'','address':'' ,'phone': ''},
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
            axios.get('/clients').then(function (response) {
                that.items = response.data;

                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },


        createItem: function(){
            var input = this.newItem;
            if((input['dni'] == '')||(input['name'] == '')||(input['last_name'] == '')||(input['address'] == '')||(input['phone'] == '')){
                toastr.warning('Complete todos los campos', {timeOut: 5000});
            }
            else{
                axios.post('/clients',input)
                .then(response => {
                    this.newItem = {'dni':'','name':'','last_name':'','address':'' ,'phone': ''},
                    toastr.success('Cliente creado', {timeOut: 5000});
                });
            }
        }
    }
}
</script>
