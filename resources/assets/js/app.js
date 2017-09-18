/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//--------------------------Dealers----------------------------------------
Vue.component('dealers', require('./components/Dealers.vue'));
Vue.component('adddealer', require('./components/CreateDealers.vue'));
//-----------------------Clients-------------------------------------------
Vue.component('clients',require('./components/Clients.vue'));
Vue.component('addclient',require('./components/CreateClients.vue'));
//------------------------Laboratories
Vue.component('laboratories',require('./components/Laboratories.vue'));
Vue.component('addlaboratory',require('./components/CreateLaboratory.vue'));
//-------------------Presentacion--------------------------------------------
Vue.component('presentations',require('./components/Presentations.vue'));
Vue.component('addpresentation',require('./components/CreatePresentation.vue'))
//-------------------- Medicine -------------------------------------------
Vue.component('medicines',require('./components/Medicines.vue'));
Vue.component('addmedicine',require('./components/CreateMedicine.vue'));
//------------------------- Purchase --------------------------------------
Vue.component('purchases',require('./components/Purchases.vue'));
Vue.component('addpurchase',require('./components/CreatePurchase.vue'));
//------------------------- Sale --------------------------------------
Vue.component('addinvoce',require('./components/CreateInvoceSale.vue'));
Vue.component('addbill',require('./components/CreateBillSale.vue'));

const app = new Vue({
    el: '#app'
});