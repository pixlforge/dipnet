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
Vue.component('Documents', require('./components/document/Documents'));
Vue.component('Deliveries', require('./components/delivery/Deliveries'));
Vue.component('OrderPreparation', require('./components/order/OrderPreparation.vue'));
Vue.component('AddDefaultBusiness', require('./components/company/AddDefaultBusiness'));
Vue.component('Login', require('./components/login/Login'));
Vue.component('ShowBusiness', require('./components/business/ShowBusiness'));
Vue.component('Tickers', require('./components/ticker/Tickers'));
Vue.component('ActiveTicker', require('./components/ticker/ActiveTicker'));
Vue.component('ShowContact', require('./components/contact/ShowContact'));

export const eventBus = new Vue()

/**
 * Vue constructor
 */
const app = new Vue({
  el: '#app',
  store
})