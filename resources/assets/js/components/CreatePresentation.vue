<template> 
<div class="col-md-10 col-md-offset-1">
    <div class="x_panel">
        <div class="x_title">
            <h2><small>Crear nueva presentación de medicamentos</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        	<!-- start form for validation -->
            <form class="form-horizontal form-label-left" novalidate>
               
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Presentación <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name"  required="required" type="text" v-model="newItem.name">
                        </div>
                    </div>
            </form>
            <div class="ln_solid"></div>
            <div class="form-group text-center">
                <div class="col-md-6 col-sm-6 col-xs-6 ">
                    <button class="btn btn-primary" >Listar</button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 center">
                     <button class="btn btn-success" @click.prevent="createItem()">Guardar presentación</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){ 
        return{
            items: [],
            newItem : {'name':''},
            formErrors: {},
            formErrorsUpdate: {},
        }
    },

    methods : {
        createItem: function(){
            var input = this.newItem;
            if(input['name'] == ''){
                toastr.warning('Complete todos los campos', {timeOut: 5000});
            }
            else{
                axios.post('/presentations',input)
                .then(response => {
                    this.newItem = {'name':''},
                    toastr.success('Nueva presentación creada', {timeOut: 5000});
                });
            }
        }
    }
}
</script>