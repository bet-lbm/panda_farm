<template>
    <div class="col-md-12 col-sm-12 col-xs-12">
    	<div class="x_panel">
    		<div class="row x_title">
    			<h2 class="col-md-6 text-danger"><i class="fa fa-warning"></i> ANULAR VENTA </h2>
            </div>
            <div class="clearfix"></div>
            <div class="x_content">
                <form class="row form-horizontal form-label-left" v-on:submit.prevent="showItem()">
                    <div class="form-group col-md-5 col-sm-5 col-xs-12">
                        <label class="control-label col-md-6 col-sm-6 col-xs-6">Comprobante : </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" required="required" v-model="type">
                                <option value="B">BOLETA</option>
                                <option value="F">FACTURA</option>
                            </select>
                        </div>
                    </div>                  
                    <div class="form-group col-md-3 col-sm-3 col-xs-6">
                        <label class="control-label col-md-4 col-sm-4 col-xs-6">Serie</label>
                        <div class="col-md-7 col-sm-7 col-xs-6">
                            <input class="form-control text-uppercase" placeholder="F001" required="required" v-model="series">
                        </div>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-6">
                        <label class="control-label col-md-2 col-sm-2 col-xs-6">N°</label>
                        <div class="col-md-8 col-sm-8 col-xs-6">
                            <input style="text-align:right;" class="form-control" placeholder="0000001" required="required" v-model="number">
                        </div>
                    </div>
                    <div class="form-group col-md-1 col-sm-1 col-xs-12">
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="ln_solid"></div>
                <div class="clearfix"></div>
                <div class="jumbotron">
                    <div class="row">
                        <h4 class="col-md-6 col-sm-6 col-xs-6">{{ fillItem.type }}: {{ fillItem.series }}-{{ fillItem.number }}</h4>
                        <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                            <h4 class="pull-right"><i class="fa fa-calendar"></i> {{ fillItem.date }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-md-8 col-xs-6 invoice-info">
                            <address>
                                <br><i class="fa fa-user"></i><b> ID: </b>{{ fillClient.dni }} 
                                <br><i class="fa fa-male"></i><b> Denominación: </b>{{ fillClient.name }}  {{ fillClient.last_name }}
                                <br><i class="fa fa-map-marker"></i><b> Dirección: </b> {{ fillClient.address }}
                            </address>
                        </div>
                        <div class="col-sm-4 col-md-4 col-xs-6 invoice-header">
                            <h4 class="text-center">
                                <i class="fa fa-plus-circle"></i> <b><br> PANDA <br> FARM </b>
                            </h4>
                        </div>
                    </div>
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-striped"> 
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
                        <small class="col-md-6 col-sm-6 col-xs-6"><i class="fa fa-info-circle"></i>DOCUMENTO SIN VALIDEZ OFICIAL</small>
                        <div class="col-md-6 col-sm-6 col-xs-6 pull-right">
                            <small class="pull-right"><i class="fa fa-child"></i> CAJERO: {{ fillItem.user }}</small>
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
            type:'',
            series:'',
            number:'',
            details:[],
            fillItem: {'series':'','number':'','type':'','client':'','user':'','date':'','subtotal':'','igv':'','total_price':''},
            fillClient: {'dni':'','name':'','last_name':'','address':'' ,'phone': '', 'id':''},
		}
	},

    mounted() {

    },
    methods : {
        showItem: function(){
            var that = this;
            axios.get('/sales/' + that.series+'/'+ that.number).then(function (response) {
                that.fillItem.date = response.data.date;
            });

            /*axios.get('/sales/show/' + that.series+'/'+ that.number).then(function (response) {
                that.details = response.data;
            });
            
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
            */
            if (this.type == 'F') {
                this.fillItem.type = 'FACTURA';
            } else {
                this.fillItem.type = 'BOLETA DE VENTA';               
            };
        },

        cancelItem: function(item){
            axios.delete('/dealers/'+item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.error('Distribuidor eliminado.', {timeOut: 5000});
            });
        },
	}
}
</script>