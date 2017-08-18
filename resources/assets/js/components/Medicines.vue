<template>
    <div class="col-md-12 col-sm-12 col-xs-12">
    	<div class="x_panel">
    		<div class="x_title">
    			<h5>Lista de medicamentos</h5>
    			<a class="pull-right"><i class="fa fa-plus"></i></a>
    				
    			<div class="clearfix"></div>
    		</div>
            
    		<div class="x_content">
    			<table class="table table-hover" role="grid"> 
    				<thead>
    					<tr>
    						<th>#</th>
    						<th>Medicicamento</th>
    						<th>Presentación</th>
    						<th>Tipo</th>
    						<th>Precio Venta</th>
    						<th>Stock</th>
                            <th>Vencimiento</th>
    						<th colspan="3">&nbsp;</th>
    					</tr>
    				</thead>
    				<tbody>
    					<tr v-for="(item, index) in items">
    						<th>{{ index + 1 + (pagination.current_page - 1) * 10 }}</th>
    						<td>{{ item.name }}</td>
    						<td>{{ item.presentation_name}}</td>
    						<td>{{ item.type }}</td>
    						<td>{{ item.sale_price}}</td>
    						<td>{{ item.stock }}</td>
                            <td>{{ item.expiration_date}}</td>
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
	            axios.get('/medicines?page='+page).then(function (response) {
	                that.items = response.data.data.data;
	                that.pagination = response.data.pagination;

	                that.$nextTick(function() {
	                    $('[data-toggle="popover"]').popover();
	                })
	            });
	        },

	        
	        changePage: function(page) {
	            this.pagination.current_page = page;
	            this.getVueItems(page);
	        }
		}
	}
</script>