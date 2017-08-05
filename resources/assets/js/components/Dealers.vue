<template>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-warning alert-dismissible fade in" role="alert" v-bind:class="{ hidden: hasDeleted }">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        Deleted Successfully!
    </div>

	<div class="x_panel">
		<div class="x_title">
			<h2><small>Lista de distribuidores</small></h2>
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
						<th>RUC</th>
						<th>Nombre</th>
						<th>Dirección</th>
						<th>Telefono</th>
						<th colspan="3">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in items">
						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
						<td>{{ item.ruc }}</td>
						<td>{{ item.name }}</td>
						<td>{{ item.address }}</td>
						<td>{{ item.phone }}</td>
						<td width="10px">
							<a class="btn btn-success"> 
                                <i class="fa fa-eye"></i>
							</a>
						</td>
						<td width="10px">
							<a title="Edit" data-toggle="modal" data-target=".bs-example-modal-lg" @click.prevent="editItem(item)" class="btn btn-warning"> <i class="fa fa-pencil"></i>
							</a>
						</td>
						<td width="10px">
                            <a  @click.prevent="deleteItem(item)" title="Delete" class="btn btn-danger"> 
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
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
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <small class="modal-title" id="myModalLabel"> Editar Distribuidor </small> 
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ruc">RUC</label>
                        <input type="text" class="form-control" name="ruc" v-model="fillItem.ruc">
                        <span v-if="formErrors['ruc']" class="error text-danger">
                        @{{ formErrors['ruc'][0] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="name">Razón Social: </label>
                        <input type="text" class="form-control" name="name" v-model="fillItem.name">
                        <span v-if="formErrors['last_name']" class="error text-danger">
                            @{{ formErrors['name'][0] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control" name="address" v-model="fillItem.address">
                    </div>
                    <div class="form-group">
                        <label for="phone">Dirección</label>
                        <input type="tel" class="form-control" name="phone" v-model="fillItem.phone">
                    </div>
                    <div class="pmd-modal-action">
                        <button data-dismiss="modal" class="btn pmd-btn-raised btn-primary" type="button" @click.prevent="updateItem()">Save changes</button>
                        <button data-dismiss="modal"  class="btn btn-default" type="button">Discard</button>
                    </div>
                    </div>
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
		    newItem : {'ruc':'','name':'','address':'' ,'phone': ''},
		    fillItem : {'ruc':'','name':'','address':'' ,'phone': '', 'id':''},
		    hasError: true,
		    hasDeleted: true,
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

        showItem: function(id) {
            this.get('/dealer/' + id + '/edit').then(function(response) {
                this.item.ruc = response.data.ruc;
                this.item.name = response.data.name;
                this.item.address = response.data.address;
                this.item.phone = response.data.pone;
            });
        },

        deleteItem: function(item){
            axios.delete('/dealer/'+item.id).then((response) => {
                this.getVueItems();
                this.hasError = true,
                this.hasDeleted = false
            });
        },

        changePage: function(page) {
                this.pagination.current_page = page;
                this.getVueItems(page);
        },

        editItem: function(item) {
            this.fillItem = item;
            this.formErrors = '';
        },

        updateItem: function() {
            var input = this.fillItem;
            var id = this.fillItem.id;
            var that = this;
            axios.patch('/dealer/' + id, input).then(function (response) {
                that.getItems();
            })
            .catch(function (error) {
                that.formErrors = error.response.data;
            });
        },
	}
}
</script>