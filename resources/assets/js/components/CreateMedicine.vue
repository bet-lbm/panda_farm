<template>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  	<div class="x_title">
					<h5>Crear nuevo medicamento</h5>
					<div class="clearfix"></div>
				</div>
			  	<div class="x_content">
			  		<form class="form-horizontal form-label-left" method="POST" v-on:submit.prevent="createItem()">
					    <div class="row">
					    	<div class="col-md-6 col-sm-6 col-xs-12">

								<div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="batch">Lote <span class="required">*</span></label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="batch" name="batch" type="text" required="required" v-model="newItem.batch" autofocus="autofocus">
				                    </div>
				                </div>
				                
				                <div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="name">Nombre <span class="required">*</span></label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="name" name="name" type="text" required="required" v-model="newItem.name">
				                    </div>
				                </div>
				                
				                <div class="form-group">
			                        <label class="control-label col-md-3 col-sm-3 col-xs-6">Descripción <span class="required">*</span>
			                        </label>
			                        <div class="col-md-8 col-sm-8 col-xs-6">
			                          <textarea class="form-control" rows="3" id="description" name="description" v-model="newItem.description"></textarea>
			                        </div>
			                    </div>
								<div class="divider-dashed"></div>
							    <div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6">Presentación <span class="required">*</span></label>
				                    <div class="col-md-6 col-sm-6 col-xs-3">
										<select class="form-control" v-model="newItem.presentation_id">
											<option v-for="presentation in presentations" :value="presentation.id">{{ presentation.name }}</option>
										</select>
				                    </div>
				                    <form action="POST" v-on:submit.prevent="openModal()">
									<button class="col-md-1 col-sm-1 col-xs-1 btn btn-primary" title="Nuevo" type="submit" ><i class="fa fa-plus"></i></button>
									</form>
				                </div>
	
								<div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6">Tipo <span class="required">*</span></label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
										<select class="form-control" v-model="newItem.type">
											<option>generico</option>
											<option>comercial</option>
										</select>
				                    </div>
				                </div>

						    </div>
						    
						    <div class="col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6">Componente <span class="required">*</span>
				                    </label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="component" data-validate-length-range="8" name="component" required="required" type="text" v-model="newItem.component">
				                    </div>
				                </div>
				                <div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6">Concentración <span class="required">*</span>
				                    </label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="concentration" data-validate-length-range="8" name="concentration" required="required" type="text" v-model="newItem.concentration">
				                    </div>
				                </div>					

				                <div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6">Stock <span class="required">*</span>
				                    </label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="stock" name="stock" required="required" type="number" min="0" v-model="newItem.stock">
				                    </div>
				                </div>
								<div class="divider-dashed"></div>
				                <div class="form-group">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Precio de Compra <span class="required">*</span>
				                    </label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<input id="purchase_price" name="purchase_price" required="required" type="number"  min="0" class="form-control"  placeholder="1.00" v-model="newItem.purchase_price" step="any">

									</div>
				                </div>

								<div class="form-group">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Precio de Venta <span class="required">*</span>
				                    </label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<input class="input form-control" id="sale_price" name="sale_price" required="required" type="number"  min="0" placeholder="1.00" v-model="newItem.sale_price" step="any">
									</div>
				                </div>

				                <div class="form-group">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">IGV <span class="required">*</span>
				                    </label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<output id="igv" name="igv" type="number" disabled="disabled" class="form-control"  > {{ calculateIgv }} </output>
							
									</div>
				                </div>


						    </div>
					    </div>
					    <div class="divider-dashed"></div>
						<div class="row">
							<div class="form-group col-md-6">
			                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Fecha de producción <span class="required">*</span>
			                    </label>
			                   	<datepicker  calendar-button calendar-button-icon="fa fa-calendar" language="es" :format="customFormatter" placeholder="Select Date" v-model="date"></datepicker>
								<output type="hidden" style="visibility:hidden">{{ dateFormatP }}</output>
			                </div>

			                <div class="form-group col-md-6">
			                    <label class="control-label col-md-4 col-sm-4 col-xs-6"> Fecha de expiración <span class="required">*</span>
			                    </label>
			                   <datepicker  calendar-button calendar-button-icon="fa fa-calendar" language="es" :format="customFormatter" placeholder="Select Date" v-model="date2"></datepicker>
								<output type="hidden" style="visibility:hidden">{{ dateFormatE }}</output>
					        </div>
						</div>
					    <div class="ln_solid"></div>
					    <div class="form-group pull-right">
	                        <button class="btn btn-primary">Listar medicamentos</button>                  
	                        <button class="btn btn-success" type="submit">Guardar medicamento</button>
		                </div>
	                </form>
			  	</div>
			</div>
		</div>
	<div class="modal fade" id="create-pre" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4><small class="modal-title" id="myModalLabel"> Nueva presentación </small></h4>  
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">Presentación :</label>
                            <div class="col-md-6 col-xs-12" >
                                <input type="text" class="form-control" name="name" v-model="newPresentation.name">
                            </div>
                            <span v-if="formErrors['name']" class="error text-danger">
                                @{{ formErrors['name'][0] }}
                            </span>
                        </div>
                        <div class="modal-footer">
                                <button @click.prevent="createPresentation()" class="btn btn-primary"> Guadar </button>
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
</template>
<script>
	import Datepicker from 'vuejs-datepicker';

	export default {
	    data(){ 
	        return{
	        	date: '',
	        	date2: '',
	        	presentations: [],
	        	newPresentation : {'name':''},
	        	items:[],
	            newItem :  {'batch':'','name':'','description':'','presentation_id':'','type':'' ,'component':'' ,'concentration':'','stock':'','purchase_price':'' ,'sale_price': '','igv': '','expiration_date':'','production_date':'' },
	            formErrors: {},
	            formErrorsUpdate: {},
	        }
	    },
	    components: {
        	Datepicker
    	},
	    computed: {
	        calculateIgv: function(){
	            return this.newItem.igv= Math.round(0.18* this.newItem.sale_price*100)/100;
	        },
	        dateFormatP: function() {
		    	let date = new Date(this.date);
		      	return this.newItem.production_date = date.getFullYear() + '-'
                                        + ('0' + (date.getMonth()+1)).slice(-2) + '-'
                                        + ('0' + date.getDate()).slice(-2);
		    },
		    dateFormatE: function() {
		    	let date = new Date(this.date2);
		      	return this.newItem.expiration_date = date.getFullYear() + '-'
                                        + ('0' + (date.getMonth()+1)).slice(-2) + '-'
                                        + ('0' + date.getDate()).slice(-2);
		    }
	    },
	   created() {
	        this.getPresentation();
     	},
	    
	    methods : {
	    	customFormatter(date) {
      			return moment(date).format('DD-MM-YYYY');
    		},
    		
    		getVueItems: function(){
	            var that = this;
	            axios.get('/medicines').then(function (response) {
	                that.items = response.data;

	                that.$nextTick(function() {
	                    $('[data-toggle="popover"]').popover();
	                })
	            });
	        },

	    	getPresentation: function(){
	            var that = this;
	            axios.get('/presentations/combo').then(function (response) {
	                that.presentations = response.data;
	            });
	        },

	        createItem: function(){
	            var input = this.newItem;
	           	if((input['batch'] == '')||(input['name'] == '')||(input['stock'== ''])){
                	toastr.warning('Complete todos los campos', {timeOut: 5000});
	            }
	            else{
	                axios.post('/medicines',input)
		            .then(response => {
		                this.newItem = {'batch':'','name':'','description':'','presentation_id':'','type':'' ,'component':'' ,'concentration':'','stock':'','purchase_price':'' ,'sale_price': '','igv': '','expiration_date':'','production_date':'' },
		                toastr.success('Medicamento creado', {timeOut: 5000});
		            });
	            }
	           
	        },
	        openModal: function(){
	        	$("#create-pre").modal('show');
	        },
	        createPresentation: function(){
	       	var input = this.newPresentation;
            if(input['name'] == ''){
                toastr.warning('Complete todos los campos', {timeOut: 5000});
            }
            else{
                axios.post('/presentations',input)
                .then(response => {
                    $("#create-pre").modal('hide');
                    this.getPresentation();
                    this.newPresentation = {'name':''},
                    toastr.success('Nueva presentación creada', {timeOut: 5000});
                });
            }
        }


	    }
	}
</script>