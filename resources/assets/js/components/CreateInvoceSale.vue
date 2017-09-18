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
                            <div class="col-xs-12 table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Serial #</th>
                                            <th style="width: 59%">Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Call of Duty</td>
                                            <td>455-981-221</td>
                                            <td>El snort testosterone trophy driving gloves handsome gerry Richardson helvetica tousled street art master testosterone trophy driving gloves handsome gerry Richardson
                                            </td>
                                            <td>$64.50</td>
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
                        <h5 class="modal-title" id="myModalLabel"> BUSCAR CLIENTE </h5> 
                    </div>
                    <div class="modal-body">
                        <div class="x_panel">
                            <div class="row x_title">
                                <h5 class="col-md-4"></i> CLIENTE </h5>
                                <div class="col-md-6 pull-right top_search">
                                    <div class="input-group">
                                        <input class="form-control" type="text" v-model="queryString" v-on:keyup="getResults()" placeholder="Buscar">
                                        <span class="input-group-btn">  <button class="btn btn-default"><i class="fa fa-search"></i></button></span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="x_content ">
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
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button"><i class="fa fa-hand-o-right"></i> Seleccionar</button>
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
                newItem :  {'series':'','number':'','tipo':'','client_id':'','user_id':'','date':'','subtotal':'','igv':'','total_price':''},
                newDetail: {'sales_id':'','medicine_id':'','medicine_name':'','quantity':'','price':'','subtotal':''},
                fillClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''},
                formErrors: {},
                formErrorsUpdate: {},
                pagination: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1,
                },
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
            },

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
                    that.pagination=response.data.pagination;
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
                        toastr.success('Agregado a la compra',{timeOut: 5000});
                       
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
            showClient: function(page) {
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
            }  
        }
    }
</script>