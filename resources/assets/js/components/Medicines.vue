<template>
    <div class="col-md-12 col-sm-12 col-xs-12">
    	<div class="x_panel">
    		<div class="x_title">
    			<h5>Lista de medicamentos</h5>
    			<a class="pull-right"><i class="fa fa-plus"></i></a>
    				
    			<div class="clearfix"></div>
    		</div>
            <div class="input-group">
                <input  class="form-control" type="text" v-model="queryString" v-on:keyup="getResults()" placeholder="BUSCAR">
            </div>
    		<div class="x_content">
    			<table class="table table-hover" role="grid"> 
    				<thead>
    					<tr class="text-center">
    						<th>#</th>
    						<th>Medicicamento</th>
                            <th>Presentación</th>
                            <th>Tipo</th>
    						<th>Precio Venta (S/.)</th>
    						<th>Stock</th>
                            <th>Vencimiento</th>
    						<th colspan="3">&nbsp;</th>
    					</tr>
    				</thead>
    				<tbody>
    					<tr v-for="(item, index) in items"> 
    						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
    						<td>{{ item.name }}</td>
                            <td>{{ item.presentation_id }}</td>
    						<td>{{ item.type }}</td>
    						<td class="text-center">{{ item.sale_price}}</td>
    						<td class="text-center"> {{ item.stock }}</td>
                            <td class="text-center">{{ item.expiration_date}}</td>
    						<td width="10px">
    							<button class="btn btn-success"  @click.prevent="showItem(item)" title="Show"> 
                                    <i class="fa fa-eye"></i>
    							</button>
    						</td>
    						<td width="10px">
                                <button class="btn btn-warning" @click.prevent="editItem(item)" title="Edit">    
                                <i class="fa fa-pencil"></i>
                                </button>
                            </td>
    						<td width="10px">
                                <button class="btn btn-danger" @click.prevent="deleteItem(item)" title="Delete">
                                <i class="fa fa-trash"></i>
                                </button>
                            </td>
    					</tr>
    				</tbody>
    			</table>
                <div class="ln_solid"></div>
                <nav class="pull-right" v-if="pagination.last_page > 1"  v-cloak>
                    <ul class="pagination">
                        <li v-if="pagination.current_page > 1">
                            <a href="#" aria-label="Previous" @click="changePage(pagination.current_page - 1)">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '' ]">
                            <a href="#" @click="changePage(page)">
                                {{ page }}
                            </a>
                        </li>
                        <li v-if="pagination.current_page < pagination.last_page">
                            <a href="#" aria-label="Next" @click="changePage(pagination.current_page + 1)">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
    		</div>   
    	</div>

        <div class="modal" id="show-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> <small>Detalles de medicamento</small> </h4> 
                    </div>
                    <div class="modal-body">
                        <div class="x_panel">
                            <div class="x_title">
                                <div class="row">
                                    <h5><i class="fa fa-medkit"></i> <b> Medicamento : </b> {{ fillItem.name }}</h5>
                                </div>
                            </div>  
                            <div class="x_content">
                                <div class="row">
                                    <p class="text-right"><i class="fa fa-cube"></i><b> Lote : </b> {{ fillItem.batch }}</p>
                                </div>
                                <div class="divider-dashed"></div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p class="text-justify"><i class="fa fa-info-circle"></i><b> Descripción: </b> {{ fillItem.description }} </p>
                                        <p><i class="fa fa-flask"></i><b> Tipo: </b> {{ fillItem.type }} </p>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p class="text-justify"><i class="fa fa-flask"></i><b> Componete: </b> {{ fillItem.component }} </p> 
                                        <p><i class="fa fa-flask"></i><b> Concentración: </b> {{ fillItem.concentration }} </p>
                                        <p><i class="fa fa-cubes"></i><b> Stock : </b> {{ fillItem.stock }} </p>
                                    </div>
                                </div>
                                <div class="divider-dashed"></div>

                                <div class="well" style="overflow: auto">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p><i class="fa fa-money"></i><b> Precio de compra : S/.</b> {{ fillItem.purchanse_price }} </p>
                                        <p><i class="fa fa-calendar"></i> <b> Fecha de producción: </b>{{ fillItem.production_date }} </p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p class="text-success"><i class="fa fa-money"></i><b> Precio de venta : S/.</b> {{ fillItem.sale_price }} </p>
                                        <p class="text-danger"><i class="fa fa-calendar"></i><b> Fecha de expiración: </b>{{ fillItem.expiration_date }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4><small class="modal-title" id="myModalLabel"> Editar Medicamento </small></h4>  
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6" for="batch">Lote <span class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                            <input class="form-control" id="batch" name="batch" type="text" required="required" v-model="fillItem.batch" autofocus="autofocus">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6" for="name">Nombre <span class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                            <input class="form-control" id="name" name="name" type="text" required="required" v-model="fillItem.name">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6">Descripción <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                          <textarea class="form-control" rows="3" id="description" name="description" v-model="fillItem.description"></textarea>
                                        </div>
                                    </div>
                                    <div class="divider-dashed"></div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6">Presentación <span class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                            <select class="form-control" v-model="fillItem.presentation_id">
                                                <option v-for="presentation in presentations" :value="presentation.id">{{ presentation.name }}</option>
                                            </select>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6">Tipo <span class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                            <select class="form-control" v-model="fillItem.type">
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
                                            <input class="form-control" id="component" data-validate-length-range="8" name="component" required="required" type="text" v-model="fillItem.component">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6">Concentración <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                            <input class="form-control" id="concentration" data-validate-length-range="8" name="concentration" required="required" type="text" v-model="fillItem.concentration">
                                        </div>
                                    </div>                  

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-6">Stock <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-8 col-xs-6">
                                            <input class="form-control" id="stock" name="stock" required="required" type="number" min="0" v-model="fillItem.stock">
                                        </div>
                                    </div>
                                    <div class="divider-dashed"></div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-6">Precio de Compra <span class="required">*</span>
                                        </label>
                                        <div class="input-group col-md-7 col-sm-7 col-xs-6">
                                            <span class="input-group-addon">S/.</span>
                                            <input id="purchanse_price" name="purchanse_price" required="required" type="number"  min="0" class="form-control" v-model="fillItem.purchanse_price" step="any">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-6">Precio de Venta <span class="required">*</span>
                                        </label>
                                        <div class="input-group col-md-7 col-sm-7 col-xs-6">
                                            <span class="input-group-addon">S/.</span>
                                            <input class="input form-control" id="sale_price" name="sale_price" required="required" type="number"  min="0" v-model="fillItem.sale_price" step="any">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-6">IGV <span class="required">*</span>
                                        </label>
                                        <div class="input-group col-md-7 col-sm-7 col-xs-6">
                                            <span class="input-group-addon">S/.</span>
                                            <output id="igv" name="igv" type="number" disabled="disabled" class="form-control">
                                                {{ calculateIgv }}
                                            </output>
                                
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="divider-dashed"></div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-6">Fecha de producción <span class="required">*</span>
                                    </label>
                                    <datepicker  calendar-button calendar-button-icon="fa fa-calendar" language="es" :format="customFormatter" v-model="date" :placeholder="fillItem.production_date"> </datepicker>
                                    <output style="visibility:hidden">{{ dateFormatP }}</output>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-6"> Fecha de expiración <span class="required">*</span>
                                    </label>
                                   <datepicker  calendar-button calendar-button-icon="fa fa-calendar" language="es" :format="customFormatter" v-model="date2" :placeholder = "fillItem.expiration_date"> </datepicker>
                                   <output style="visibility:hidden">{{ dateFormatE }}</output>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"> Guadar cambios </button>
                                <button data-dismiss="modal"  class="btn btn-default" type="button">Cancelar</button>
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
			    items: [],
                presentations: [],
			    pagination: {
	                total: 0,
	                per_page: 2,
	                from: 1,
	                to: 0,
	                current_page: 1,
	            },
	            offset: 4,
	            formErrors: {},
	            formErrorsUpdate: {},
                fillItem:  {'batch':'','name':'','description':'','presentation_id':'','type':'' ,'component':'' ,'concentration':'','stock':'','purchanse_price':'' ,'sale_price': '','igv': '','expiration_date':'','production_date':'', 'id':''},
                queryString:''
			}
		},
        components:{
            Datepicker
        },
		computed: {
                calculateIgv: function(){
                    return this.fillItem.igv= Math.round(0.18* this.fillItem.sale_price*100)/100;
                },
                dateFormatP: function() {
                    let date = new Date(this.date);
                    return this.fillItem.production_date = date.getFullYear() + '-'
                                            + ('0' + (date.getMonth()+1)).slice(-2) + '-'
                                            + ('0' + date.getDate()).slice(-2);
                },
                dateFormatE: function() {
                    let date = new Date(this.date2);
                    return this.fillItem.expiration_date = date.getFullYear() + '-'
                                            + ('0' + (date.getMonth()+1)).slice(-2) + '-'
                                            + ('0' + date.getDate()).slice(-2);
                },
                
                isActived: function() {
                    return this.pagination.current_page;
                },

                pagesNumber: function() {
                    if (!this.pagination.to) {
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
	                if (to >= this.pagination.last_page) {
	                    to = this.pagination.last_page;
	                }
	                var pagesArray = [];
	                while (from <= to) {
	                    pagesArray.push(from);
	                    from++;
	                }
	                return pagesArray;
	            }
	    },
  	    mounted() {
            this.getPresentation();
            this.getVueItems(this.pagination.current_page);
	    },
	    methods : {
            
            customFormatter(date) {
                return moment(date).format('DD-MM-YYYY');
            },
            
            getPresentation: function(){
                var that = this;
                axios.get('/presentations/c').then(function (response) {
                    that.presentations = response.data;
                });
            },
	        getVueItems: function(page){
	        	var that = this;
	            axios.get('/medicines?page='+page).then(function (response) {
	                that.items = response.data.data.data;
	                that.pagination = response.data.pagination;

	                that.$nextTick(function() {
	                    $('[data-toggle="popover"]').popover();
	                })
	            });
	        },
            getResults(){
                 var that=this;
                axios.get('/medicines/search',{params:{queryString:this.queryString}}).then(response=>{
                    that.items=response.data.data.data;
                    that.pagination=response.data.pagination;
                 })
             },
            showItem: function(item){
                this.fillItem.id = item.id;
                this.fillItem.batch=item.batch;
                this.fillItem.name = item.name;
                this.fillItem.description=item.description;
                this.fillItem.presentation_id=item.presentation_id;
                this.fillItem.type=item.type;
                this.fillItem.component=item.component;
                this.fillItem.concentration=item.concentration;
                this.fillItem.stock=item.stock;
                this.fillItem.purchanse_price=item.purchanse_price;
                this.fillItem.sale_price=item.sale_price;
                this.fillItem.igv=item.igv;
                this.fillItem.production_date=item.production_date;
                this.fillItem.expiration_date=item.expiration_date;
                $("#show-item").modal('show');
                
            },
	        editItem: function(item) {
                this.fillItem.id = item.id;
                this.fillItem.batch=item.batch;
                this.fillItem.name = item.name;
                this.fillItem.description=item.description;
                this.fillItem.presentation_id=item.presentation_id;
                this.fillItem.type=item.type;
                this.fillItem.component=item.component;
                this.fillItem.concentration=item.concentration;
                this.fillItem.stock=item.stock;
                this.fillItem.purchanse_price=item.purchanse_price;
                this.fillItem.sale_price=item.sale_price;
                this.fillItem.igv=item.igv;
                this.fillItem.production_date=item.production_date;
                this.fillItem.expiration_date=item.expiration_date;
                $("#edit-item").modal('show');
            },

            updateItem: function(id) {
                var input = this.fillItem;
                axios.put('/medicines/'+id,input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {'batch':'','name':'','description':'','presentation_id':'','type':'' ,'component':'' ,'concentration':'','stock':'','purchanse_price':'' ,'sale_price': '','igv': '','expiration_date':'','production_date':'', 'id':''};
                    this.date = '';
                    this.date2 = '';
                    $("#edit-item").modal('hide');
                    toastr.success('Medicamento editado', {timeOut: 5000});
                }, 
                (response) => {
                        this.formErrorsUpdate = response.data;
                });
            },
            deleteItem: function(item){
                axios.delete('/medicines/'+item.id).then((response) => {
                    this.changePage(this.pagination.current_page);
                    toastr.error('Medicamento  eliminado.', {timeOut: 5000});
                });
            },
	        changePage: function(page) {
	            this.pagination.current_page = page;
	            this.getVueItems(page);
	        }
		}
	}
</script>