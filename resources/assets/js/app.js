
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
require('./fontawesome')
require('./packs/light')
require('./packs/solid')

window.Vue = require('vue')

/**
 * Vue components
 */
Vue.component('flash', require('./components/flash/Flash.vue'))
Vue.component('app-dropdown', require('./components/dropdown/Dropdown.vue'))
Vue.component('app-searchbar', require('./components/search/Searchbar.vue'))
Vue.component('app-register', require('./components/register/Register.vue'))
Vue.component('app-account-details', require('./components/account/AccountDetails.vue'))
Vue.component('app-account-contact', require('./components/account/AccountContact.vue'))
Vue.component('app-account-company', require('./components/account/AccountCompany.vue'))
Vue.component('app-profile', require('./components/profile/Profile.vue'))
Vue.component('app-contacts', require('./components/contact/Contacts.vue'))
Vue.component('app-formats', require('./components/format/Formats.vue'))
Vue.component('app-businesses', require('./components/business/Businesses.vue'))
Vue.component('app-show-company', require('./components/company/ShowCompany.vue'))

Vue.component('app-articles', require('./components/articles/Articles.vue'))
Vue.component('app-users', require('./components/users/Users.vue'))
Vue.component('app-companies', require('./components/company/Companies.vue'))
Vue.component('app-orders', require('./components/order/Orders.vue'))
Vue.component('app-create-order', require('./components/order/CreateOrder.vue'))

export const eventBus = new Vue()

/**
 * Vue constructor
 */
const app = new Vue({
    el: '#app'
});