import { store } from './store/store'

require('./bootstrap')
require('./fontawesome')
require('./packs/light')
require('./packs/solid')

window.Vue = require('vue')

/**
 * Global Vue components
 */
Vue.component('navbar', require('./components/navbar/Navbar.vue'));
Vue.component('flash', require('./components/flash/Flash.vue'));
Vue.component('register', require('./components/register/Register.vue'));
Vue.component('account-contact', require('./components/account/AccountContact.vue'));
Vue.component('account-company', require('./components/account/AccountCompany.vue'));
Vue.component('profile', require('./components/profile/Profile.vue'));
Vue.component('contacts', require('./components/contact/Contacts.vue'));
Vue.component('formats', require('./components/format/Formats.vue'));
Vue.component('businesses', require('./components/business/Businesses.vue'));
Vue.component('show-company', require('./components/company/ShowCompany.vue'));
Vue.component('articles', require('./components/article/Articles.vue'));
Vue.component('users', require('./components/users/Users.vue'));
Vue.component('companies', require('./components/company/Companies.vue'));
Vue.component('orders', require('./components/order/Orders.vue'));
Vue.component('documents', require('./components/document/Documents'));
Vue.component('deliveries', require('./components/delivery/Deliveries'));
Vue.component('create-order', require('./components/order/CreateOrder.vue'));
Vue.component('order-admin', require('./components/order/AdminOrder'));
Vue.component('add-default-business', require('./components/business/AddDefaultBusiness'));
Vue.component('login', require('./components/login/Login'));
Vue.component('show-business', require('./components/business/ShowBusiness'));
Vue.component('tickers', require('./components/ticker/Tickers'));
Vue.component('active-ticker', require('./components/ticker/ActiveTicker'));

export const eventBus = new Vue()

/**
 * Vue constructor
 */
const app = new Vue({
  el: '#app',
  store
})