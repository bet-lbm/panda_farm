<template>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5 class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-credit-card"></i> <b>FACTURA:</b> {{ newItem.series }} - {{ newItem.number }}</h5>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h5 class="pull-right"><i class="fa fa-calendar-o"></i> {{ today }}</h5>
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <section class="content invoice">
                        <div class="row">
                            <div class="col-sm-3 col-md-3  col-xs-12 invoice-header">
                                <h1 class="text-center ">
                                    <i class="fa fa-plus-circle"></i><br> PANDA <br> FARM
                                </h1>
                            </div>

                            <div class="col-sm-5 col-md-5 col-xs-6 invoice-info">
                                <div class="x_panel">
                                    <address>
                                        <br><b> RUC: </b>{{ fillClient.dni }}
                                        <br><b> Razón Social: </b>{{ fillClient.name }}  {{ fillClient.last_name }}
                                        <br><b> Dirección: </b> {{ fillClient.address }}  
                                        <br>
                                        <button type="button" class="btn btn-link pull-right" @click.prevent="showClient()"><i class="fa fa-search"></i></button>
                                    </address>
                                </div>
                            </div>

                            <div class=" col-sm-4 col-md-4 col-xs-6 invoice-col">
                                <div class="x_panel">
                                    <address class="text-center">
                                        <br>RUC: 20123456789
                                        <br>795 Freedom Ave, Suite 600, Tacna - Perú
                                        <br>Teléfono: +51 (080) 123-9876
                                        <br>Email: info@panda.com
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Medicamento</label>
                                    <div class="col-md-8 col-sm-8 col-xs-6">
                                        <select class="form-control" v-model="newDetail.medicine_id" @change="getMedicineName">
                                                <option v-for="medicine in medicines" :value="medicine.id">{{ medicine.name }}</option>
                                        </select>
                                    </div>
                                </div>                  
                                <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-6">Cantidad</label>
                                    <div class="col-md-8 col-sm-8 col-xs-6">
                                        <input style="text-align:right;" class="form-control" type="number" min="5"aria-hidden v-model="newDetail.quantity">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-6">Precio Compra</label>
                                    <div class="input-group col-md-7 col-sm-7 col-xs-6">
                                        <span class="input-group-addon">S/.</span>
                                        <input style="text-align:right;" type="number"  min="0" class="form-control" step="any" v-model="newDetail.price" placeholder="00.00">
                                    </div>
                                </div>
                                <div class="form-group col-md-1 col-sm-1 col-xs-12">
                                   <button type="button" class="btn btn-primary pull-right" @click.prevent="createDetail()"> <i class="fa fa-plus"></i> </button>
                                </div>
                            </div>
                            <output style="visibility:hidden" >{{ calculateSubtotal }}</output>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="row">
                            <div class="col-xs-12 table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cant.</th>
                                            <th style="width: 59%">Medicamento</th>
                                            <th>P.Unitario</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="detail in details"> 
                                            <td>{{ detail.quantity }}</td>
                                            <td>{{ detail.medicine_name }}</td>
                                            <td>S/. {{ detail.price }}</td>
                                            <td>  </td>
                                            <td>S/. {{ detail.subtotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 20px;">
                                No se realiza cambio ni devolución de dinero por los productos adquiridos, por favor verifique el estado de cada uno de los items de su compra. 
                                </p>
                            </div>
                            <div class="col-xs-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>IGV (18%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                              <th>Total:</th>
                                              <td>$265.24</td>
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
                                <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Realizar Venta</button>
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
                                                <input class="form-control" type="text" v-model="queryString" v-on:keyup="getResults()" placeholder="RUC...">
                                                <span class="input-group-btn">  <button class="btn btn-default"><i class="fa fa-search"></i></button></span>
                                            </div>
                                        </div>
                
                                        <table class="table"> 
                                            <thead>
                                                <tr> 
                                                    <th>RUC</th>
                                                    <th>Razón Social</th>
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
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4">RUC : </label>
                                                <div class="col-md-8 col-sm-7 col-xs-12">
                                                    <input class="form-control col-md-8 col-xs-6" required="required" type="text" v-model="newClient.dni">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-4">Razón Social : </label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-6" required="required" type="text" v-model="newClient.name">
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
                serie: 'F001',
                clients: [],
                medicines: [],
                details:[],
                items:[],
                newItem: {'series':'','number':'','tipo':'','client_id':'','user_id':'','date':'','subtotal':'','igv':'','total_price':''},
                newDetail: {'sales_id':'','medicine_id':'','medicine_name':'','quantity':'','price':'','subtotal':''},
                fillClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''},
                newClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': ''},
                formErrors: {},
                formErrorsUpdate: {},
                queryString:'',
            }
        },
        computed: {
            today: function()
            {
                return this.date.toLocaleString("es-CL", {year: "numeric", month: "numeric",day: "numeric"});
            },
            calculateSubtotal: function(){
                return this.newDetail.subtotal = Math.round(this.newDetail.quantity * this.newDetail.price*100)/100 ; 
            },
            calculateTotal:function(){
                var array = this.details;
                var result = 0;
                for (var i = 0; i < array.length; i++) { 
                    result = result + array[i].subtotal; 
                }
                return this.newItem.total_price = Math.round(result*100)/100 ; ;
            }
        },
       created() {
            this.getCode();
            this.getMedicine();
        },
        
        methods : {
            getCode: function(){
                var that = this;
                this.newItem.series = this.serie;
                axios.get('/sales/code/invoce').then( function (response) {
                    that.newItem.number = response.data;
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
            
            getMedicineName: function(){
                var that = this;
                axios.get('/medicines/get/'+ that.newDetail.medicine_id).then(function (response) {
                    that.newDetail.medicine_name = response.data;
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
                        this.details.push(this.newDetail);
                        toastr.success('Agregado a la venta',{timeOut: 5000});
                       
                    }
                    this.newDetail = {'purchase_id':'','medicine_id':'','medicine_name':'','quantity':'','price':'','subtotal':''};
                }
                console.log(that.details);
            },

            deleteDetail:function(index){
                this.details.splice(index,1);
                this.description.splice(index,1);
            },
            
            createItem: function(){
                var input = this.newItem;
                var array = this.details;
                if((input['dealer_id'] == '')||(input['laboratory_id'] == '')||(input['date'] == '')||(input['total_price'] == '')){
                    toastr.warning('Complete todos los campos', {timeOut: 5000});
                }
                else{
                    axios.post('/purchases',input)
                    .then(response => {
                        for (var i = 0; i < array.length; i++) { 
                            array[i].purchase_id = input['code'];
                            axios.post('/purchasedetails', array[i]);
                            axios.put('/purchasedetails/stock');                
                        };
                        toastr.success('Actualice sus precios de venta','COMPRA REALIZADA',{timeOut: 5000});
                        this.newItem = {'code':'','dealer_id':'','laboratory_id':'','date':'','total_price':''},
                        this.getCode();
                    });
                    this.details = [];
                    this.description = [];
                }
            },
            showClient: function() {
                var that = this;
                $("#show-client").modal('show');
            },
            selectClient: function(client){
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

                });

            }  
        }
    }
</script>