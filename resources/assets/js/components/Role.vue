<template>
<form class="form-horizontal">
	<div class="row form-group">
	    <label for="role" class="col-md-4 control-label">Rol :</label>
	    <div class="col-md-6">
	        <select id="role" name="role" class="form-control" v-model="rol" required autofocus> 
				<option v-for="role in roles">{{ role.name }}</option>
			</select>
			{{ rol }} {{ user }}
	    </div>
	</div>
</form>
</template>
<script>
	export default{
		data(){
			return{
				roles:[],
				rol:'',
				user:'',
			}
		},
		mounted(){
			this.getRoles();
			this.getUser();
		},
		methods:{
			getUser(){
				var that = this;
				axios.get('/getuser').then( function(response) {
                    that.user = response.data;
                });
			},
			getRoles(){
	            var that=this;
	            axios.get('/roles').then(response=>{
	                that.roles=response.data;
	            })
	        },
		}
	}
</script>