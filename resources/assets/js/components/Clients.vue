<template>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="row x_title">
            <h5 class="col-md-6 "> Lista de Clientes</h5>
            <div class="col-md-4 pull-right top_search">
                <div class="input-group">
                    <input class="form-control" type="text" v-model="queryString" v-on:keyup="getResults()" placeholder="Buscar">
                    <span class="input-group-btn">  <button class="btn btn-default"><i class="fa fa-search"></i></button></span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
		<div class="x_content">
			<table class="table table-hover"> 
				<thead>
					<tr>
						<th>#</th>
                        <th>DNI/RUC</th>
						<th style="width: 40%">Denominación</th>
						<th>Telefono</th>
						<th colspan="3">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in items">
						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
						<td>{{ item.dni }}</td>
                        <td>{{ item.name }} {{ item.last_name }}</td>
						<td>{{ item.phone }}</td>
						<td width="10px">
							<button class="btn btn-success" @click.prevent="showItem(item)"title="Show"> 
                                <i class="fa fa-eye"></i>
							</button>
						</td>
						<td width="10px">
							<button class="btn btn-warning" @click.prevent="editItem(item)" title="Edit">
                            <i class="fa fa-pencil"></i>
                            </button>
						</td>
						<td width="10px">
                            <button class="btn btn-danger" @click.prevent="deleteItem(item)" title="Delete"> <i class="fa fa-trash"></i>
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

    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4> <small class="modal-title" id="myModalLabel"> Editar cliente </small> </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="dni">DNI</label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" disabled="true" class="form-control" name="dni" v-model="fillItem.dni">
                            </div>
                            <span v-if="formErrors['dni']" class="error text-danger">
                            @{{ formErrors['dni'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">Nombre: </label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" name="name" v-model="fillItem.name">
                            </div>
                            <span v-if="formErrors['name']" class="error text-danger">
                                @{{ formErrors['name'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="last_name">Apellidos: </label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" name="last_name" v-model="fillItem.last_name">
                            </div>
                            <span v-if="formErrors['last_name']" class="error text-danger">
                                @{{ formErrors['last_name'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="address">Dirección</label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" name="address" v-model="fillItem.address">
                            </div>
                            <span v-if="formErrors['address']" class="error text-danger">
                                @{{ formErrors['address'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="phone">Teléfono</label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="tel" class="form-control" name="phone" v-model="fillItem.phone">
                            </div>
                            <span v-if="formErrors['phone']" class="error text-danger">
                                @{{ formErrors['phone'][0] }}
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> Guadar Cambios </button>
                            <button data-dismiss="modal"  class="btn btn-default" type="button">Cancelar</button>   
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="show-item" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4> <small class="modal-title" id="myModalLabel"> Detalles de cliente </small> </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="dni">DNI</label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" disabled="true" name="dni" v-model="fillItem.dni">
                            </div>
                        
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">Nombre: </label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" disabled="true" name="name" v-model="fillItem.name">
                            </div>
                        
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="last_name">Apellidos: </label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" disabled="true" name="last_name" v-model="fillItem.last_name">
                            </div>
                        
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="address">Dirección</label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="text" class="form-control" disabled="true" name="address" v-model="fillItem.address">
                            </div>
                        
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="phone">Teléfono</label>
                            <div class="col-md-6 col-xs-12">  
                               <input type="tel" class="form-control" disabled="true" name="phone" v-model="fillItem.phone">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
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
            newItem : {'dni':'','name':'','last_name':'','address':'' ,'phone': ''},
            fillItem : {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''},
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
            axios.get('/clients?page='+page).then(function (response) {
                that.items = response.data.data.data;
                that.pagination = response.data.pagination;

                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },
        getResults(){
            var that=this;
            axios.get('/clients/search',{params:{queryString:this.queryString}}).then(response=>{
                that.items=response.data.data.data;
                that.pagination=response.data.pagination;
               /* that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })*/
            })
        },

        showItem: function(item) {
            this.fillItem.id = item.id;
            this.fillItem.dni = item.dni;
            this.fillItem.name = item.name;
            this.fillItem.last_name = item.last_name;
            this.fillItem.address = item.address;
            this.fillItem.phone = item.phone;
            $("#show-item").modal('show');
        },

        editItem: function(item) {
            this.fillItem.id = item.id;
            this.fillItem.dni = item.dni;
            this.fillItem.name = item.name;
            this.fillItem.last_name = item.last_name;
            this.fillItem.address = item.address;
            this.fillItem.phone = item.phone;
            $("#edit-item").modal('show');
        },

        updateItem: function(id) {
            var input = this.fillItem;
            axios.put('/clients/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {'dni':'','name':'','last_name': '','address':'' ,'phone': '', 'id':''};
                $("#edit-item").modal('hide');
                toastr.success('Cliente editado', {timeOut: 5000});
                }, (response) => {
                    this.formErrorsUpdate = response.data;
                });
        },
        
        deleteItem: function(item){
            axios.delete('/clients/'+item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.error('Cliente eliminado', {timeOut: 5000});
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
	}
}
</script>