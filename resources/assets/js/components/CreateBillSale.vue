<template>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5 class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-credit-card"></i> <b>BOLETA DE VENTA:</b> {{ newItem.series }} - {{ newItem.number }}</h5>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h5 class="pull-right"><i class="fa fa-calendar-o"></i> {{ today }}</h5>
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {{ dateFormat }}
                    <section class="content invoice">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="x_panel">
                                    <br><b> DNI: </b>{{ fillClient.dni }} 
                                    <br><b> Nombre y Apellidos: </b>{{ fillClient.name }}  {{ fillClient.last_name }}
                                    <br><b> Dirección: </b> {{ fillClient.address }}  
                                    <button type="button" class="btn btn-danger pull-right" @click.prevent="showClient()"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <form class="form-horizontal form-label-left" v-on:submit.prevent="createDetail()">
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group col-md-5  col-sm-5  col-xs-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6">Medicina</label>
                                    <div class="col-md-9 col-sm-9 col-xs-6">
                                        <select class="form-control" v-model="newDetail.medicine_id" @change="getMedicineDetail" required="required">
                                                <option v-for="medicine in medicines" :value="medicine.id">{{ medicine.name }}</option>
                                        </select>
                                    </div>
                                </div>                  
                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6">cant.</label>
                                    <div class="col-md-9 col-sm-9 col-xs-6">
                                        <input style="text-align:right;" placeholder="0" class="form-control" type="number" min="1" v-model="newDetail.quantity" required="required">
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6">PU.</label>
                                    <div class="input-group col-md-9 col-sm-9 col-xs-6">
                                        <span class="input-group-addon">S/.</span>
                                        <output style="text-align:right;" class="form-control" disabled="disabled"> {{ saleP }}
                                        </output>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group col-md-1 col-sm-1 col-xs-12 pull-right">
                                   <button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-plus"></i> </button>
                                </div>
                                <div class="form-group col-md-3 col-sm-3 col-xs-12 pull-right">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6">dto.</label>
                                    <div class="input-group col-md-9 col-sm-9 col-xs-6">
                                        <input style="text-align:right;" class="form-control" v-model="dto" placeholder="0">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                                <output style="visibility:hidden" class="pull-right">{{ calculateSubtotal }}</output>
                                <output style="visibility:hidden" class="pull-right">{{ calculateDiscount }}</output>
                                <output style="visibility:hidden" class="pull-right">{{ calculateSalePrice }}</output>                     
                            </div>
                        </form>

                        <div class="row">
                            <div class="ln_solid"></div>
                            <div class="col-xs-12 table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cant.</th>
                                            <th style="width: 59%">Medicamento</th>
                                            <th>PU </th>
                                            <th>Dto.</th>
                                            <th>PV. </th>
                                            <th>SubTotal</th>
                                            <th colspan="1">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detail,index) in details"> 
                                            <td>{{ detail.quantity }}</td>
                                            <td>{{ detail.medicine_name }}</td>
                                            <td>{{ Math.round((detail.discount + detail.sale_price)*100)/100 }}</td>
                                            <td>{{ detail.discount }}</td>
                                            <td>S/.{{ detail.sale_price }}</td>
                                            <td>S/.{{ detail.subtotal }}</td>
                                            <td width="10px">
                                                <button class="btn-link" title="Quitar" @click.prevent="deleteDetail(index)">
                                                <i class="fa fa-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <output style="visibility:hidden" class="pull-right">{{ calculateOP }} {{ calculateIGV }}</output>
                        </div>
                        
                        <div class="row">

                            <div class="form-horizontal form-label-left col-xs-8">
                                <div class="row">
                                    <p class="col-md-3 control-label"> <b>PAGO EN EFECTIVO</b> </p>
                                    <div class="col-md-5 col-xs-12">
                                        <label class="col-md-4 control-label">SOLES:</label>
                                        <div class="input-group col-md-8">
                                            <span class="input-group-addon">S/.</span>
                                            <input style="text-align:right;" class="form-control" v-model="cash"> 
                                        </div> 
                                    </div>
                                    <output class="col-md-4 col-xs-12">VUELTO: <b>{{ Math.round((cash - newItem.total_price)*100)/100 }}</b></output>
                                </div>
                            </div>
                            
                                
                            <div class="col-xs-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                              <th>TOTAL:</th>
                                              <td>S/.{{ calculateTotal }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- this row will not appear when printing -->
                        <div class="ln_solid"></div>
                        <div class="row no-print">
                            <div class="col-xs-12">
                                <button class="btn btn-success pull-right" @click.prevent="createItem()"><i class="fa fa-credit-card"></i> Realizar Venta</button>
                                <button class="btn btn-default pull-right" style="margin-right: 5px;"><i class="fa fa-print"></i>Imprimir</button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal" id="show-client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title" id="myModalLabel"> CLIENTES </h5> 
                    </div>
                    <div class="modal-body">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <p class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                        <i class="fa fa-search"></i> Buscar cliente </a>
                                    </p>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        
                                        <div class="row top_search">
                                            <label class="control-label col-md-3 col-sm-5 col-xs-6">Buscar : </label>
                                            <div class="input-group col-md-9 col-sm-7 col-xs-6">
                                                <input class="form-control" type="text" v-model="queryString" v-on:keyup="getResults()" placeholder="DNI..." autofocus="autofocus">
                                                <span class="input-group-btn">  <button class="btn btn-default"><i class="fa fa-search"></i></button></span>
                                            </div>
                                        </div>
                
                                        <table class="table"> 
                                            <thead>
                                                <tr> 
                                                    <th>DNI</th>
                                                    <th>Nombres y Apellidos</th>
                                                    <th colspan="1">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr  v-for="client in clients">
                                                    <th>{{ client.dni }}</th>
                                                    <th>{{ client.name }} {{ client.last_name }}</th>
                                                    <td width="10px">
                                                        <button class="btn-link" @click.prevent="selectClient(client)" title="Seleccionar">
                                                        <i class="fa fa-check"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <p class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                        <i class="fa fa-user"></i> Agregar nuevo cliente</a>
                                    </p>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                         <form class="form-horizontal form-label-left">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4">DNI : </label>
                                                <div class="col-md-8 col-sm-7 col-xs-12">
                                                    <input class="form-control col-md-8 col-xs-6" required="required" type="text" v-model="newClient.dni">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4">Nombres : </label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-6" required="required" type="text" v-model="newClient.name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4">Apellidos : </label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-6" required="required" type="text" v-model="newClient.last_name">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4" for="address">Dirección : </label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" required="required" type="text" v-model="newClient.address">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4" for="phone">Teléfono : </label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" required="required" type="tel" v-model="newClient.phone"> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                                                    <button class="btn btn-success pull-right" @click.prevent="createClient()"><i class="fa fa-save"></i> Guardar Cliente</button>
                                                </div>
                                            </div>

                                        </form>
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
                date: new Date(),
                serie: 'B001',
                dto: '',
                saleP:'',
                cash:'',
                description: [],
                clients: [],
                medicines: [],
                details:[],
                items:[],
                newItem: {'series':'','number':'','type':'','client_id':'','user_id':'','date':'','subtotal':'','igv':'','total_price':'','enabled':''},
                newDetail: {'sale_series':'','sale_number':'','medicine_id':'','medicine_name':'','quantity':'','sale_price':'','discount':'','subtotal':''},
                fillClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''},
                newClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': ''},
                queryString:'',
            }
        },
        computed: {
            today: function()
            {
                return this.date.toLocaleString("es-CL", {year: "numeric", month: "numeric",day: "numeric"});
            },
            dateFormat: function() {
                let date = new Date(this.date);
                this.newItem.date = date.getFullYear() + '-'
                                        + ('0' + (date.getMonth()+1)).slice(-2) + '-'
                                        + ('0' + date.getDate()).slice(-2);
            },
            calculateSubtotal: function(){
                return this.newDetail.subtotal = Math.round(this.newDetail.quantity * this.newDetail.sale_price*100)/100; 
            },
            calculateDiscount: function(){
                return this.newDetail.discount = Math.round((this.saleP * (this.dto / 100) )*100)/100; 
            },
            calculateSalePrice: function(){
                return this.newDetail.sale_price = ((this.saleP - this.newDetail.discount)*100)/100;
            },
            calculateTotal:function(){
                var array = this.details;
                var result = 0;
                for (var i = 0; i < array.length; i++) { 
                    result = result + array[i].subtotal; 
                }
                return this.newItem.total_price = Math.round(result*100)/100 ; ;
            },
            calculateIGV: function(){
                return this.newItem.igv = Math.round( 0.18 * this.newItem.total_price * 100 ) / 100;
            },
            calculateOP: function(){
                return this.newItem.subtotal = Math.round((this.newItem.total_price - this.newItem.igv)*100)/100;
            }

        },
       created() {
            this.getCode();
            this.getMedicine();
        },
        
        methods : {
            getClient: function(){
                var that = this;
                axios.get('/clients/get/'+that.fillClient.dni).then (function(response){
                    that.newItem.client_id=response.data;
                });
            },
            getCode: function(){
                var that = this;
                this.newItem.series = this.serie;
                this.newItem.type = 'B';
                this.newItem.enabled =true;
                axios.get('/sales/code/bill').then( function (response) {
                    that.newItem.number = response.data;
                });
                axios.get('/getuser').then( function(response) {
                    that.newItem.user_id = response.data;
                });
            },

            getMedicine: function(){
                var that = this;
                axios.get('/medicines/combo').then(function (response) {
                    that.medicines = response.data;
                });
            },

            getResults(){
                var that=this;
                axios.get('/clients/search/dni',{params:{queryString:this.queryString}}).then(response=>{
                    that.clients=response.data.data.data;
                })
            },
            
            getMedicineDetail: function(){
                var that = this;
                axios.get('/medicines/get/'+ that.newDetail.medicine_id).then(function (response) {
                    that.newDetail.medicine_name = response.data; 
                });
                axios.get('/medicines/saleprice/'+ that.newDetail.medicine_id).then(function (response) {
                    that.saleP = response.data;
                });
            },

            createDetail:function(){
                var that = this;
                var input = this.newDetail;
                if((input['medicine_id'] == '')||(input['medicine_name'] == '')||(input['quantity'] == '')||(input['price'] == '')||(input['subtotal'] == '')){
                    toastr.warning('Complete todos los campos', {timeOut: 5000});
                }
                else{
                    if(this.details.map(i => i.medicine_id).includes(input['medicine_id'])){    
                        toastr.error('Escoja otro medicamento para agregar a la compra','MEDICAMENTO YA AGREGADO', {timeOut: 5000});
                    }
                    else{
                        this.details.push(input);
                        toastr.success('Agregado a la venta',{timeOut: 5000});
                    }
                }
                this.newDetail = {'sale_series':'','sale_number':'','medicine_id':'','medicine_name':'','quantity':'','sale_price':'','discount':'','subtotal':''};
                this.dto = '';
                this.saleP ='';

            },

            deleteDetail:function(index){
                this.details.splice(index,1);
                this.description.splice(index,1);
            },
            
            createItem: function(){
                var input = this.newItem;
                var array = this.details;
                if((input['client_id'] == '')||(input['user_id'] == '')||(input['date'] == '')||(input['total_price'] == '')){
                    toastr.warning('Complete todos los campos', {timeOut: 5000});
                }
                else{
                    axios.post('/sales',input)
                    .then(response => {
                       for (var i = 0; i < array.length; i++) { 
                            array[i].sale_series = input['series'];
                            array[i].sale_number = input['number'];                           
                            axios.post('/saledetails', array[i]);
                            axios.put('/saledetails/stock');                
                        };
                        toastr.success('VENTA REALIZADA',{timeOut: 5000});
                        this.newItem = {'series':'','number':'','type':'','client_id':'','user_id':'','date':'','subtotal':'','igv':'','total_price':'','enabled':''},
                        this.getCode();
                        this.fillClient = {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''};
                    });
                    this.details = [];
                    this.description = [];
                    this.cash='';
                }
            },
            showClient: function() {
                var that = this;
                $("#show-client").modal('show');
            },
            selectClient: function(client){
                this.newItem.client_id = client.id;
                this.fillClient.dni = client.dni;
                this.fillClient.name = client.name;
                this.fillClient.last_name = client.last_name;
                this.fillClient.address = client.address;
                this.fillClient.phone = client.phone;
                $("#show-client").modal('hide');
                this.queryString = '';
                this.clients = '';
            },
            createClient: function(){
                var input = this.newClient;
                this.fillClient.dni = this.newClient.dni;
                this.fillClient.name = this.newClient.name;
                this.fillClient.address = this.newClient.address;
                var that = this;
                axios.post('/clients',input)
                .then(response => {
                    that.newClient = {'dni':'','name':'','last_name':'','address':'' ,'phone': ''},
                    $("#show-client").modal('hide');
                    toastr.success('Cliente creado', {timeOut: 5000});
                    this.getClient();
                });

            }
        }
    }
</script>