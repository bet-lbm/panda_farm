<template>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  	<div class="x_title">
					<h5>Crear nuevo medicamento</h5>
					<div class="clearfix"></div>
				</div>
			  	<div class="x_content">
					<form class="form-horizontal form-label-left">
					    <div class="row">
					    	<div class="col-md-6 col-sm-6 col-xs-12">

								<div class="form-group">
				                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="batch">Lote <span class="required">*</span></label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="batch" name="batch" type="text" required="required" v-model="newItem.batch">
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
				                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Presentación <span class="required">*</span></label>
				                    <div class="col-md-6 col-sm-6 col-xs-11">
										<select class="form-control" v-model="newItem.presentation_id">
											<option v-for="presentation in presentations">{{ presentation.name }}</option>
										</select>
				                    </div>
									<button class="col-md-1 col-sm-1 col-xs-1 btn btn-primary" title="Edit"><i class="fa fa-plus"></i></button>
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
				                        <input class="form-control" id="stock" name="stock" required="required" type="number" min="1" v-model="newItem.stock">
				                    </div>
				                </div>
								<div class="divider-dashed"></div>
				                <div class="form-group">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Precio de Compra <span class="required">*</span>
				                    </label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<input id="purchanse_price" name="purchanse_price" required="required" type="number" class="form-control" v-model="newItem.purchanse_price">
									</div>
				                </div>

								<div class="form-group">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Precio de Venta <span class="required">*</span>
				                    </label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<input class="input form-control" id="sale_price" name="sale_price" required="required" type="number" v-model="newItem.sale_price">
									</div>
				                </div>

				                <div class="form-group">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">IGV <span class="required">*</span>
				                    </label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<output id="igv" name="igv" type="number" disabled="disabled" class="form-control" v-model="newItem.igv" > {{ calculateIgv }} </output> 
									</div>
				                </div>


						    </div>
					    </div>
					    <div class="divider-dashed"></div>
						<div class="row">
							<div class="well" style="overflow: auto">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<fieldset>
										<div class="control-group">
											<div class="controls">
												Fecha de producción
												<div class="col-md-6 xdisplay_inputx input-group has-feedback">
													<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
													<input class="form-control has-feedback" id="single_cal2" placeholder="Ingrese fecha" aria-describedby="inputSuccess2Status2" type="date" name="production_date" v-model="newItem.production_date">
													<span id="inputSuccess2Status2" class="sr-only">(success)</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<fieldset>
										<div class="control-group">
											Fecha de expiración
											<div class="controls">
												<div class="col-md-6 xdisplay_inputx input-group has-feedback">
													<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
													<input class="form-control has-feedback" id="single_cal4" placeholder="Ingrese fecha" aria-describedby="inputSuccess2Status4" type="date" name="expiration_date" v-model="newItem.expiration_date" data-date-format="dd/mm/yy">
													<span id="inputSuccess2Status4" class="sr-only">(success)</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>

					    <div class="ln_solid"></div>
					    <div class="form-group pull-right">
	                        <button class="btn btn-primary">Listar medicamentos</button>                  
	                        <button class="btn btn-success" @click.prevent="createItem()">Guardar medicamento</button>
		                </div>
	                </form>
			  	</div>
			</div>
		</div>
    </div>
</template>
<script>
	export default {
	    data(){ 
	        return{
	        	presentations: [],
	            newItem : {'batch':'','name':'','description':'','presentation_id':'','type':'' ,'component':'' ,'concentration':'','expiration_date':'','production_date':'' ,'stock':'','purchanse_price':'' ,'sale_price': '','igv': '' },
	            formErrors: {},
	            formErrorsUpdate: {},
	        }
	    },
	    computed: {
	        calculateIgv: function(){
	            return this.newItem.igv= 0.18* this.newItem.sale_price;
	        }
	    },
	    mounted() {
	        this.getPresentation();
	    },

	    methods : {

	    	getPresentation: function(){
	            var that = this;
	            axios.get('/presentations').then(function (response) {
	                that.presentations = response.data.data.data;
	            });
	        },

	        createItem: function(){
	            var input = this.newItem;
	            if((input['batch'] == '')||(input['name'] == '')||(input['type'] == '')||(input['component'] == '')||(input['expiration_date'] == '')){
	                toastr.warning('Complete todos los campos', {timeOut: 5000});
	            }
	            else{
	                axios.post('/medicines',input)
	                .then(response => {
	                    this.newItem = {'batch':'','name':'','description':'','presentation_id':'','type':'' ,'component':'' ,'concentration':'','expiration_date':'','production_date':'' ,'stock':'','purchanse_price':'' ,'sale_price': '','igv': '' },
	                    toastr.success('Cliente creado', {timeOut: 5000});
	                });
	            }
	        }
	    }
	}
</script>