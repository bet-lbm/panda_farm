<template>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h4><small>Lista de Clientes</small></h4>
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
                        <th>DNI</th>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Dirección</th>
						<th>Telefono</th>
						<th colspan="3">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in items">
						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
						<td>{{ item.dni }}</td>
                        <td>{{ item.name }}</td>
						<td>{{ item.last_name }}</td>
						<td>{{ item.address }}</td>
						<td>{{ item.phone }}</td>
						<td width="10px">
							<button class="btn btn-success" title="Show"> 
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4> <small class="modal-title" id="myModalLabel"> Editar cliente </small> </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" name="dni" v-model="fillItem.dni">
                            <span v-if="formErrors['dni']" class="error text-danger">
                            @{{ formErrors['dni'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre: </label>
                            <input type="text" class="form-control" name="name" v-model="fillItem.name">
                            <span v-if="formErrors['name']" class="error text-danger">
                                @{{ formErrors['name'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Apellidos: </label>
                            <input type="text" class="form-control" name="last_name" v-model="fillItem.last_name">
                            <span v-if="formErrors['last_name']" class="error text-danger">
                                @{{ formErrors['last_name'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" name="address" v-model="fillItem.address">
                            <span v-if="formErrors['address']" class="error text-danger">
                                @{{ formErrors['address'][0] }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="tel" class="form-control" name="phone" v-model="fillItem.phone">
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
            fillItem : {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''}
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

        showItem: function(id) {
            this.get('/clients/' + id + '/edit').then(function(response) {
                this.item.ruc = response.data.ruc;
                this.item.name = response.data.name;
                this.item.address = response.data.address;
                this.item.phone = response.data.phone;
            });
        },

        deleteItem: function(item){
            axios.delete('/clients/'+item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
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
                toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
                }, (response) => {
                    this.formErrorsUpdate = response.data;
                });
        },
        
        changePage: function(page) {
                this.pagination.current_page = page;
                this.getVueItems(page);
        }
	}
}
</script>