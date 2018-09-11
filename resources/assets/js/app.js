import { store } from './store/store'

require('./bootstrap')
require('./fontawesome/fontawesome')
require('./fontawesome/light')
require('./fontawesome/solid')

window.Vue = require('vue')

/**
 * Global Vue components
 */
Vue.component('Navbar', require('./components/navbar/Navbar.vue'));
Vue.component('Flash', require('./components/flash/Flash.vue'));
Vue.component('Register', require('./components/register/Register.vue'));
Vue.component('AccountContact', require('./components/account/AccountContact.vue'));
Vue.component('AccountCompany', require('./components/account/AccountCompany.vue'));
Vue.component('Profile', require('./components/profile/Profile.vue'));
Vue.component('Contacts', require('./components/contact/Contacts.vue'));
Vue.component('Formats', require('./components/format/Formats.vue'));
Vue.component('Businesses', require('./components/business/Businesses.vue'));
Vue.component('ShowCompany', require('./components/company/ShowCompany.vue'));
Vue.component('Articles', require('./components/article/Articles.vue'));
Vue.component('Users', require('./components/users/Users.vue'));
Vue.component('Companies', require('./components/company/Companies.vue'));
Vue.component('Orders', require('./components/order/Orders.vue'));
Vue.component('OrderPreparation', require('./components/order/OrderPreparation.vue'));
Vue.component('AddDefaultBusiness', require('./components/company/AddDefaultBusiness'));
Vue.component('Login', require('./components/login/Login'));
Vue.component('ShowBusiness', require('./components/business/ShowBusiness'));
Vue.component('Tickers', require('./components/ticker/Tickers'));
Vue.component('ActiveTicker', require('./components/ticker/ActiveTicker'));
Vue.component('ShowContact', require('./components/contact/ShowContact'));
Vue.component('ShowUser', require('./components/users/ShowUser'));
Vue.component('ShowTicker', require('./components/ticker/ShowTicker'));
Vue.component('ShowArticle', require('./components/article/ShowArticle'));
Vue.component('ShowFormat', require('./components/format/ShowFormat'));

export const eventBus = new Vue()

/**
 * Vue constructor
 */
const app = new Vue({
  el: '#app',
  store
})