<template>
    <div class="col-md-12 col-sm-12 col-xs-12">
    	<div class="x_panel">
    		<div class="row x_title">
    			<h5 class="col-md-6"> <i class="fa fa-bars"></i> Lista de distribuidores </h5>
                <div class="col-md-4 pull-right top_search">
                    <div class="input-group">
                        <input class="form-control" type="text" v-model="queryString" v-on:keyup="getResults()" placeholder="Buscar">
                        <span class="input-group-btn">  <button class="btn btn-default"><i class="fa fa-search"></i></button></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
    		<div class="x_content">
    			<table class="table table-hover" role="grid"> 
    				<thead>
    					<tr>
    						<th>#</th>
    						<th>RUC</th>
    						<th>Nombre/Razón Social</th>
    						<th>Teléfono</th>
    						<th colspan="3">&nbsp;</th>
    					</tr>
    				</thead>
    				<tbody>
    					<tr v-for="(item, index) in items">
    						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
    						<td>{{ item.ruc }}</td>
    						<td>{{ item.name }}</td>
    						<td>{{ item.phone }}</td>
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
        
        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> <small>Editar Distribuidor</small> </h4> 
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
                            <div class="form-group">
                                <label class="control-label col-md-3" for="ruc">RUC : </label>
                                <div class="col-md-8 col-xs-12">
                                    <input class="form-control" disabled="true" type="text" name="ruc" v-model="fillItem.ruc" />
                                </div>
                                <span v-if="formErrorsUpdate['ruc']" class="error text-danger">{{ formErrorsUpdate['ruc'] }}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="name">Razón Social : </label>
                                <div class="col-md-8 col-xs-12">    
                                    <input class="form-control" type="text" name="name" v-model="fillItem.name" autofocus/>
                                </div>
                                <span v-if="formErrorsUpdate['name']" class="error text-danger">{{ formErrorsUpdate['name'] }}</span> 
                            </div>             
                            <div class="form-group">
                                <label class="control-label col-md-3" for="address">Dirección : </label>
                                <div class="col-md-8 col-xs-12">    
                                    <input type="text" name="address" class="form-control" v-model="fillItem.address" />
                                </div>
                                <span v-if="formErrorsUpdate['address']" class="error text-danger">{{ formErrorsUpdate['address'] }}</span>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3" for="phone">Teléfono : </label>
                                <div class="col-md-8 col-xs-12">    
                                    <input type="text" name="phone" class="form-control" v-model="fillItem.phone"/>
                                </div>
                                <span v-if="formErrorsUpdate['phone']" class="error text-danger">{{ formErrorsUpdate['phone'] }}</span>
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

        <div class="modal" id="show-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title" id="myModalLabel"> Detalles de distribuidor </h5> 
                    </div>
                    <div class="modal-body">
                        <div class="x_panel">
                        <div class="row x_title">
                            <p><i class="fa fa-info"></i><b> RUC:</b> {{ fillItem.ruc }} </p>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <p class="col-md-3 col-sm-3 col-xs-3"> <i class="fa fa-user"></i> <b> Razón Social:</b></p>
                                <p class="col-md-9 col-sm-9 col-xs-9">{{ fillItem.name }} </p>
                            </div>
                            <div class="row">
                                <p class="col-md-3 col-sm-3 col-xs-3"><i class="fa fa-map-marker"></i><b> Dirección:</b></p>
                                <p class="col-md-9 col-sm-9 col-xs-9"> {{ fillItem.address }} </p>
                            </div>
                            <div class="row">
                                <p class="col-md-3 col-sm-3 col-xs-3"> <i class="fa fa-phone"></i> <b> Teléfono:  </b></p>
                                <p class="col-md-9 col-sm-9 col-xs-9"> {{ fillItem.phone }} </p>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-link">Volver</button>
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
            newItem : {'id': '','ruc':'','name':'','address':'' ,'phone': ''},
            fillItem : {'ruc':'','name':'','address':'' ,'phone': '', 'id':''},
            queryString:''
		}
	},
	computed: {
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
        this.getVueItems(this.pagination.current_page);
    },
    methods : {

        getVueItems: function(page){
        	var that = this;
            axios.get('/dealers?page='+page).then(function (response) {
                that.items = response.data.data.data;
                that.pagination = response.data.pagination;

                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },
        getResults(){
            var that=this;
            axios.get('/dealers/search',{params:{queryString:this.queryString}}).then(response=>{
                that.items=response.data.data.data;
                that.pagination=response.data.pagination;
               /* that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })*/
            })
        },
        showItem: function(item){
            this.fillItem.ruc = item.ruc;
            this.fillItem.id = item.id;
            this.fillItem.name = item.name;
            this.fillItem.address = item.address;
            this.fillItem.phone = item.phone;
            $("#show-item").modal('show');
            
        },

        editItem: function(item){
            this.fillItem.ruc = item.ruc;
            this.fillItem.id = item.id;
            this.fillItem.name = item.name;
            this.fillItem.address = item.address;
            this.fillItem.phone = item.phone;
            $("#edit-item").modal('show');
        },

        updateItem: function(id){
            var input = this.fillItem;
            axios.put('/dealers/'+id,input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {'ruc':'','name':'','address':'' ,'phone': '', 'id':''};
                $("#edit-item").modal('hide');
                toastr.success('Distribuidor correctamente editado.', {timeOut: 5000});
            }, 
            (response) => {
                this.formErrorsUpdate = response.data;
            });
        },

        deleteItem: function(item){
            axios.delete('/dealers/'+item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.error('Distribuidor eliminado.', {timeOut: 5000});
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
	}
}
</script>