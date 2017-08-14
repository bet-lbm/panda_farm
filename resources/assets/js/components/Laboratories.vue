<template>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h4><small>Lista de Laboratorio</small></h4>
			<ul class="nav navbar-right panel_toolbox">
				<li class="pull-right">
					<a href="#" role="button" aria-expanded="false"><i class="fa fa-plus"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
        
		<div class="x_content">
			<table class="table table-hover"> 
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre</th>
						<th>Codigo Sanitario</th>
						<th>Autorizacion</th>
						<th>Telefono</th>
						<th colspan="3">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in items">
						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
                        <td>{{ item.name }}</td>
						<td>{{ item.health_code}}</td>
						<td>{{ item.authorization}}</td>
						<td>{{ item.phone }}</td>
						<td width="10px">
                          <button class="btn btn-success" @click.prevent="showItem(item)" title="Show"><i class="fa fa-eye"></i></button>
						</td>
						<td width="10px">
                            <button class="btn btn-warning" @click.prevent="editItem(item)" title="Edit"><i class="fa fa-pencil"></i></button>
						</td>
						<td width="10px">
                            <button class="btn btn-danger" @click.prevent="deleteItem(item)" title="Delete"><i class="fa fa-trash"></i></button>
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
                        <h4 class="modal-title" id="myModalLabel"> <small>Editar Laboratorio</small> </h4> 
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
                            <div class="form-group">
                                <label class="control-label col-md-4" for="name">Nombre Laboratorio: </label>
                                <div class="col-md-7 col-xs-12">    
                                    <input class="form-control" type="text" name="name" v-model="fillItem.name" autofocus/>
                                </div>
                                <span v-if="formErrorsUpdate['name']" class="error text-danger">{{ formErrorsUpdate['name'] }}</span> 
                            </div>             
                            <div class="form-group">
                                <label class="control-label col-md-4" for="health_code">Codigo Sanitario: </label>
                                <div class="col-md-7 col-xs-12">
                                    <input class="form-control" type="text" name="health_code" v-model="fillItem.health_code" />
                                </div>
                                <span v-if="formErrorsUpdate['health_code']" class="error text-danger">{{ formErrorsUpdate['health_code'] }}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" for="authorization">Autorización: </label>
                                <div class="col-md-7 col-xs-12">    
                                    <input type="text" name="authorization" class="form-control" v-model="fillItem.authorization" />
                                </div>
                                <span v-if="formErrorsUpdate['authorization']" class="error text-danger">{{ formErrorsUpdate['authorization'] }}</span>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-4" for="phone">Teléfono : </label>
                                <div class="col-md-7 col-xs-12">    
                                    <input type="text" name="phone" class="form-control" v-model="fillItem.phone"/>
                                </div>
                                <span v-if="formErrorsUpdate['phone']" class="error text-danger">{{ formErrorsUpdate['phone'] }}</span>
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

        <div class="modal" id="show-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> <small>Detalles de distribuidor</small> </h4> 
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-4" for="name">Nombre Laboratorio: </label>
                                <div class="col-md-6 col-xs-12">   
                                    <input class="form-control" disabled="true" type="text" name="name" v-model="fillItem.name"/>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="control-label col-md-4" for="authorization">Autorización : </label>
                                <div class="col-md-6 col-xs-12">    
                                    <input type="text"  disabled="true" name="authorization" class="form-control" v-model="fillItem.authorization" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" for="health_code">Codigo Sanitario: </label>
                                <div class="col-md-6 col-xs-12">
                                    <input class="form-control" disabled="true" type="text" name="health_code" v-model="fillItem.health_code" />
                                </div>
                            </div> 
                             
                            <div class="form-group">
                                <label class="control-label col-md-4" for="phone">Teléfono : </label>
                                <div class="col-md-6 col-xs-12">    
                                    <input type="text" disabled="true" name="phone" class="form-control" v-model="fillItem.phone"/>
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
            newItem : {'name':'','health_code':'','authorization':'' ,'phone': ''},
            fillItem : {'name':'','health_code':'','authorization':'' ,'phone': '', 'id':''} 
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
            axios.get('/laboratories?page='+page).then(function (response) {
                that.items = response.data.data.data;
                that.pagination = response.data.pagination;

                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },

        showItem: function(item) {
            this.fillItem.id = item.id; 
            this.fillItem.name = item.name;
            this.fillItem.health_code = item.health_code;
            this.fillItem.authorization = item.authorization;
            this.fillItem.phone = item.phone;
            $("#show-item").modal('show');  
        },

        deleteItem: function(item){
            axios.delete('/laboratories/'+item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.error('Laboratorio eliminado correctamente.', {timeOut: 5000});
            });
        },

        changePage: function(page) {
                this.pagination.current_page = page;
                this.getVueItems(page);
        },

        editItem: function(item) {
            this.fillItem.id = item.id; 
            this.fillItem.name = item.name;
            this.fillItem.health_code = item.health_code;
            this.fillItem.authorization = item.authorization;
            this.fillItem.phone = item.phone;
            $("#edit-item").modal('show');
        },

        updateItem: function(id) {
            var input = this.fillItem;
            axios.put('/laboratories/' + id,input).then( (response)=> {
                this.changePage(this.pagination.current_page);
                this.fillItem = {'name':'','health_code':'','authorization':'' ,'phone': '', 'id':''}; 
                $("#edit-item").modal('hide');
                toastr.success('Laboratorio editado correctamente.', {timeOut: 5000});          
            },
            (response) => {
              this.formErrorsUpdate = response.data;
            });
        }
	}
}
</script>