<template>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  	<div class="x_title">
					<h2> CODIGO: {{ newItem.code }}</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li> <h5><i class="fa fa-calendar-o"></i> {{ today }}</h5>
						</li>
                    </ul>
					<div class="clearfix"></div>
				</div>
			  	<div class="x_content">
			  		<form class="form-horizontal form-label-left" method="POST" v-on:submit.prevent="createItem()">
					    <div class="row">
						    <div class="col-md-12 col-sm-12 col-xs-12">
						    	<div class="well" style="overflow: auto">
						 			{{ dateFormat }}
									<div class="form-group col-md-6 col-sm-6 col-xs-12">
					                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Distribuidor</label>
					                    <div class="col-md-8 col-sm-8 col-xs-6">
											<select class="form-control" v-model="newItem.dealer_id" required="required">
												<option v-for="dealer in dealers" :value="dealer.id">{{ dealer.name }}</option>
											</select>
					                    </div>
					                </div>
					                <div class=" form-group col-md-6 col-sm-6 col-xs-12">
					                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Laboratorio</label>
					                    <div class="col-md-8 col-sm-8 col-xs-6">
											<select class="form-control" v-model="newItem.laboratory_id" required="required">
												<option v-for="laboratory in laboratories" :value="laboratory.id">{{ laboratory.name }}</option>
											</select>
					                    </div>
					                </div>
							    </div> 
							</div>
							<div class="row col-md-12 col-sm-12 col-xs-12">
							    <div class="form-group col-md-4 col-sm-4 col-xs-12">
				                    <label class="control-label col-md-5 col-sm-5 col-xs-6">Medicamento</label>
				                    <div class="col-md-7 col-sm-7 col-xs-6">
				                        <select class="form-control" v-model="newDetail.medicine_id" required="required">
												<option v-for="medicine in medicines" :value="medicine.id">{{ medicine.name }}</option>
										</select>
				                    </div>
				                </div>					
				                <div class="form-group col-md-3 col-sm-3 col-xs-12">
				                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Cantidad</label>
				                    <div class="col-md-8 col-sm-8 col-xs-6">
				                        <input class="form-control" id="stock" name="stock" required="required" type="number" min="5"aria-hidden v-model="newDetail.quantity">
				                    </div>
				                </div>
				                <div class="form-group col-md-4 col-sm-4 col-xs-12">
				                    <label class="control-label col-md-5 col-sm-5 col-xs-6">Precio Compra</label>
				                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
										<span class="input-group-addon">S/.</span>
										<input id="price" name="price" required="required" type="number"  min="0" class="form-control" step="any" v-model="newDetail.price">
									</div>
				                </div>
				                <div class="form-group col-md-1 col-sm-1 col-xs-12">
				                   <button type="button" class="btn btn-primary pull-right" @click.prevent="createDetail()"> <i class="fa fa-plus"></i> </button>
				                </div>
						    </div>
						    <output style="visibility:hidden" >{{ calculateSubtotal }}</output>
					    </div>
						<div class="x_panel">
							<div class="x_title">
								Detalle de Compra
							</div>
							<div class="x_content">
								<table class="table table-hover" role="grid"> 
				    				<thead>
				    					<tr class="text-center">
				    						<th width="20px">#</th>
				    						<th>Detalle</th>
				    						<th>Cantidad</th>
				    						<th>Precio Unitario (S/.)</th>
				    						<th>Subtotal (S/.)</th>
				    						<th colspan="1">&nbsp;</th>
				    					</tr>
				    				</thead>
				    				<tbody>
				    					<tr v-for="(detail,index) in details">
				    						<th width="20px">{{ index + 1 }}</th>
				    						<td>{{ detail.medicine_id }}</td>
				    						<td>{{ detail.quantity }}</td>
				    						<td>{{ detail.price }}</td>
				    						<td>{{ detail.subtotal }}</td>
				    						<td width="10px">
				                                <button class="btn btn-link" @click.prevent="deleteDetail(index)" title="Quitar">
				                                <i class="fa fa-close"></i>
				                                </button>
				                            </td>
				    					</tr>
				    				</tbody>
				    			</table>
							</div>
						</div>
					    <div class="ln_solid"></div>
					    <div class="form-group pull-right">  
	                        <button class="btn btn-success" type="submit"><i class="fa fa-shopping-cart"></i> Realizar compra</button>
		                </div>
	                </form>
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
	        	date: new Date(),
	        	dealers: [],
	        	laboratories: [],
	        	medicines: [],
	        	details:[],
	        	items:[],
	            newItem :  {'code':'','dealer_id':'','laboratory_id':'','date':'','total_price':''},
	            newDetail: {'purchase_id':'','medicine_id':'','quantity':'','price':'','subtotal':''},
	            formErrors: {},
	            formErrorsUpdate: {},
	        }
	    },
	    components: {
        	Datepicker
    	},
	    computed: {
	    	today: function()
	    	{
	    		return this.date.toLocaleString("es-CL", {year: "numeric", month: "numeric",day: "numeric"});
	    	},
	        dateFormat: function() {
		    	let date = new Date(this.date);
		      	this.newItem.date = date.getFullYear() + '-'
                                        + ('0' + (date.getMonth()+1)).slice(-2) + '-'
                                        + ('0' + date.getDate()).slice(-2);
		    },
		    calculateSubtotal: function(){
	            return this.newDetail.subtotal = Math.round(this.newDetail.quantity * this.newDetail.price*100)/100 ; 
	        }
	    },
	   created() {
	        this.getCode();
	        this.getDealer();
	        this.getLaboratory();
	        this.getMedicine();
     	},
	    
	    methods : {
	    	getCode: function(){
	    		var that = this;
	    		axios.get('/purchases/code').then( function (response) {
	    			that.newItem.code = response.data;
	    			that.newDetail.purchase_id = response.data;
	    		});
	    	},

	    	getDealer: function(){
	            var that = this;
	            axios.get('/dealers/combo').then(function (response) {
	                that.dealers = response.data;
	            });
	        },
	        getLaboratory: function(){
	            var that = this;
	            axios.get('/laboratories/combo').then(function (response) {
	                that.laboratories = response.data;
	            });
	        },
	        getMedicine: function(){
	            var that = this;
	            axios.get('/medicines/combo').then(function (response) {
	                that.medicines = response.data;
	            });
	        },

	        createDetail:function(){
	        	var input = this.newDetail;
	        	if((input['medicine_id'] == '')||(input['quantity'] == '')||(input['price'] == '')||(input['subtotal'] == '')){
	                toastr.warning('Complete todos los campos', {timeOut: 5000});
	            }
	            else{
	            	
	           		this.details.push(this.newDetail);
	           		this.newDetail = {'purchase_id':'','medicine_id':'','quantity':'','price':'','subtotal':''},
		            toastr.success('Agregado a la compra',{timeOut: 5000});
	           	}
	        },
	        deleteDetail:function(index){
	        	this.details.splice(index,1);
	        },
	        createItem: function(){
	            var input = this.newItem;
	            if((input['dealer_id'] == '')||(input['laboratory_id'] == '')||(input['date'] == '')||(input['total_price'] == '')){
	                toastr.warning('Complete todos los campos', {timeOut: 5000});
	            }
	            else{
	           		axios.post('/purchases',input)
		            .then(response => {
		                this.newItem = {'code':'','dealer_id':'','laboratory_id':'','date':'','total_price':''},
		                toastr.success('Actualice sus precios de venta','COMPRA REALIZADA',{timeOut: 5000});
		                this.getCode();
		            });
	           	}
	        },
	    }
	}
</script>