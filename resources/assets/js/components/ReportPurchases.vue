<template>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="row x_title">
            <div class="col-md-6 pull-right top_search">
                <div class="input-group">
                    <label class="control-label">Fecha Inicial<span class="required">*</span></label>
                    <datepicker  calendar-button calendar-button-icon="fa fa-calendar" language="es" :format="customFormatter" placeholder="Seleccione Fecha" v-model="date1"></datepicker>
                    <label class="control-label ">Fecha final<span class="required">*</span></label>
                    <datepicker  calendar-button calendar-button-icon="fa fa-calendar" language="es" :format="customFormatter" placeholder="Seleccione Fecha" v-model="date2"></datepicker>
                    <br>
                    <button class="btn btn-default" @click.prevent="getResults()">
                        Filtrar
                    </button>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
		<div class="x_content">
			<table class="table table-hover"> 
				<thead>
					<tr>
						<th>Código</th>
                        <th>Fecha</th>
                        <th>Monto (S./)</th>
						<th colspan="1">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item,index) in items">
						<td>{{ item.code }}</td>
                        <td>{{ item.date }}</td>
                        <td>{{ item.total_price }}</td>
						<td width="10px">
							<button class="btn btn-success" type="button" title="Mostrar" @click.prevent="showItem(item)"><i class="fa fa-eye"></i></button>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"> <small>DETALLES DE COMPRA</small> </h4> 
                </div>
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="row x_title">
                            <p class="col-md-6 col-sm-6 col-xs-6"><i class="fa fa-shopping-cart"></i> CODIGO: {{ fillItem.code }}</p>
                            <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                <p class="pull-right"><i class="fa fa-calendar"></i> {{ fillItem.date }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="x_content ">
                            <div class="row">
                                <p class="col-md-6 col-sm-6 col-xs-12 text-justify"><i class="fa fa-ambulance"></i><b> Distribuidor: </b> {{ fillItem.dealer }}  </p>
                                <p class="col-md-6 col-sm-6 col-xs-12 text-left"><i class="fa fa-flask"></i><b> Laboratorio: </b> {{ fillItem.laboratory }}</p>
                            </div>
                            <div class="divider-dashed"></div>
                            <div class="row col-md-12 col-sm-12 col-xs-12">
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
                                            <td width="300px">{{ detail.medicine_name }}</td>
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
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="window.print();"><i class="fa fa-print"></i> Imprimir</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
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
		    items: [],
            fillItem: {'code': '','dealer': '','laboratory': '','date': '','total_price': ''},
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
            date1:'',
            date2:''
        }
	},
    components:{
        Datepicker
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
        customFormatter(date){
            return moment(date).format('YYYY-MM-DD');
        },
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

        getResults(){
            var that=this;
            axios.get('/purchases/search_report',{params:{date1:this.date1,date2:this.date2}}).then(response=>{
                that.items=response.data.data.data;
                that.pagination=response.data.pagination;
            })
        },

        changePage: function(page) {
            this.dealers = [];
            this.laboratories =[];
            this.pagination.current_page = page;
            this.getVueItems(page);
        },

        showItem: function(item){
            var that = this;
            this.fillItem.code = item.code;
            axios.get('/dealers/get/'+ item.dealer_id).then(function (response) {
                that.fillItem.dealer =response.data;
            });
            axios.get('/laboratories/get/'+ item.laboratory_id).then(function (response) {
                that.fillItem.laboratory =response.data;
            });
            this.fillItem.date = item.date;
            this.fillItem.total_price = item.total_price;
            $("#show-item").modal('show');
            axios.get('/purchases/show/' + item.code).then(function (response) {
                that.details = response.data;
            });
        }
	}
}
</script>