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
                        <td>{{ item.series }} - {{item.number}}</td>
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

    <div class="modal" id="show-invoce" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><small>DETALLES DE VENTA</small> </h4> 
                </div>
                <div class="modal-body">
                    <div class="x_panel">
                        <div class="row x_title">
                            <p class="col-md-6 col-sm-6 col-xs-6"><b>FACTURA: {{ fillItem.series }}-{{ fillItem.number }}</b></p>
                            <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                <p class="pull-right"><i class="fa fa-calendar"></i> {{ fillItem.date }}</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="x_content ">
                            <div class="row">
                                <div class="col-sm-8 col-md-8 col-xs-6 invoice-info">
                                    <div class="x_panel">
                                        <address>
                                            <br><i class="fa fa-user"></i><b> RUC: </b>{{ fillClient.dni }} 
                                            <br><i class="fa fa-male"></i><b> Razón Social: </b>{{ fillClient.name }}  {{ fillClient.last_name }}
                                            <br><i class="fa fa-map-marker"></i><b> Dirección: </b> {{ fillClient.address }}
                                        </address>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-xs-6 invoice-header">
                                    <h3 class="text-center ">
                                        <i class="fa fa-plus-circle"></i><br> PANDA <br> FARM
                                    </h3>
                                </div>
                            </div>
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-striped table-bordered"> 
                                    <thead>
                                        <tr>
                                            <th width="10px">N°</th>
                                            <th width="55%">Descripción</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">P. Unit.</th>
                                            <th class="text-center">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detail,index) in details">
                                            <td width="10px">{{ index + 1 }}</td>
                                            <td>{{ detail.medicine_name }}</td>
                                            <td class="text-right">{{ detail.quantity }}</td>
                                            <td class="text-right">S/.{{ detail.sale_price }}</td>
                                            <td class="text-right">S/.{{ detail.subtotal }}</td>
                                           </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-5 col-sm-5 col-xs-12 pull-right">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th style="width:60%">OP. GRAVADA:</th>
                                                    <td class="text-right">S/.{{ fillItem.subtotal }}</td>
                                                </tr>
                                                <tr>
                                                    <th>IGV (18%)</th>
                                                    <td class="text-right">S/.{{ fillItem.igv }}</td>
                                                </tr>
                                                <tr>
                                                  <th>TOTAL:</th>
                                                  <td class="text-right">S/.{{ fillItem.total_price }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="col-md-6 col-sm-6 col-xs-6"><i class="fa fa-info-circle"></i><b> DOCUMENTO SIN VALIDEZ OFICIAL</b></p>
                                <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                    <p class="pull-right"><i class="fa fa-child"></i> CAJERO: {{ fillItem.user }}</p>
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
            fillItem: {'series':'','number':'','type':'','client':'','user':'','date':'','subtotal':'','igv':'','total_price':''},
            fillClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''},
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
            axios.get('/sales?page='+page).then(function (response) {
                that.items = response.data.data.data;
                that.pagination = response.data.pagination;
                that.$nextTick(function() {
                    $('[data-toggle="popover"]').popover();
                })
            });
        },

        getResults(){
            var that=this;
            axios.get('/sales/search_report',{params:{date1:this.date1,date2:this.date2}}).then(response=>{
                that.items=response.data.data.data;
                that.pagination=response.data.pagination;
            })
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        },

        showItem: function(item){
            var that = this;
            this.fillItem.series = item.series;
            this.fillItem.number = item.number;
            this.fillItem.type = item.type;
            this.fillItem.date = item.date;
            axios.get('/clients/'+item.client_id).then(function(response){
                that.fillClient.dni = response.data.dni;
                that.fillClient.name = response.data.name;
                that.fillClient.last_name = response.data.last_name;
                that.fillClient.address = response.data.address;
            });

            axios.get('/getuser/'+item.user_id).then(function(response){
                that.fillItem.user = response.data;
            });
            this.fillItem.subtotal = item.subtotal;
            this.fillItem.igv = item.igv; 
            this.fillItem.total_price = item.total_price;
            axios.get('/sales/show/' + item.series+'/'+ item.number).then(function (response) {
                that.details = response.data;
            });
            if (this.fillItem.type == 'F') {
                $("#show-invoce").modal('show');
            } else {
                $("#show-bill").modal('show');                
            };
        }
    }
}
</script>