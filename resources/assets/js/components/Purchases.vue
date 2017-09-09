<template>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h5>Lista de compras</h5>
		</div>
        
		<div class="x_content">
			<table class="table table-hover"> 
				<thead>
					<tr>
						<th>Código</th>
                        <th>Distribuidor</th>
                        <th>Laboratorio</th>
                        <th>Fecha</th>
                        <th>Total(S/.)</th>
						<th colspan="1">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in items">
						<td>{{ item.code }}</td>
                        <td>{{ item.dealer_id }}</td>
                        <td>{{ item.laboratory_id }}</td>
                        <td>{{ item.date }}</td>
                        <td>{{ item.total_price }}</td>
						<td width="10px">
							<button class="btn btn-success" title="Edit" @click.prevent="showItem(item)"><i class="fa fa-eye"></i></button>
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
                    <h4 class="modal-title" id="myModalLabel"> <small>DETALLES DE COMPRA</small> </h4> 
                </div>
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="x_title">
                           <h2><small><i class="fa fa-shopping-cart"></i> CODIGO DE COMPRA: {{ fillItem.code }}</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><h2><small><i class="fa fa-calendar"></i> {{ fillItem.date }}</small></h2>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>  
                        <div class="x_content ">
                            <div class="row">
                                <p class="col-md-6 col-sm-6 col-xs-12"><i class="fa fa-ambulance"></i><b> Distribuidor: </b> {{ fillItem.dealer_id }}  </p>
                                <p class="col-md-6 col-sm-6 col-xs-12"><i class="fa fa-flask"></i><b> Laboratorio: </b> {{ fillItem.laboratory_id }}</p>
                            </div>
                            <div class="divider-dashed"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered"> 
                                    <thead>
                                        <tr>
                                            <th width="10px">N°</th>
                                            <th width="300px">Descripción</th>
                                            <th>Cantidad</th>
                                            <th>P.U.(S/.)</th>
                                            <th>Subotal(S/.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detail,index) in details">
                                            <td width="10px">{{ index + 1 }}</td>
                                            <td width="300px">{{ detail.medicine_id}}</td>
                                            <td class="text-right">{{ detail.quantity }}</td>
                                            <td class="text-right">{{ detail.price }}</td>
                                            <td class="text-right">{{ detail.subtotal }}</td>
                                           </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-5 col-sm-5 col-xs-12 pull-right">
                                    <p class="pull-right"><big>TOTAL: S/.{{ fillItem.total_price }}</big> </p>
                                </div>
                            </div>
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
            fillItem: {'code': '','dealer_id': '','laboratory_id': '','date': '','total_price': ''},
            details: [],
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
            axios.get('/purchases?page='+page).then(function (response) {
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
        },

        showItem: function(item){
            var that = this;
            this.fillItem.code = item.code;
            this.fillItem.dealer_id=item.dealer_id;
            this.fillItem.laboratory_id = item.laboratory_id;
            this.fillItem.date = item.date;
            this.fillItem.total_price = item.total_price;
            $("#show-item").modal('show');
            axios.get('/purchases/' + item.code).then(function (response) {
                that.details = response.data;
                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });

        }
	}
}
</script>