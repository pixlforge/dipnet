// import Form from './classes.js';
// import Errors from './Errors.js';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Vue components
 */
Vue.component('register', require('./components/Register.vue'));
Vue.component('contact-details', require('./components/ContactDetails.vue'));
Vue.component('company-details', require('./components/CompanyDetails.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));

/**
 * Contact components
 */
Vue.component('show-contacts', require('./components/Contacts.vue'));
Vue.component('add-contact', require('./components/AddContact.vue'));

/**
 * Vue constructor
 */
const app = new Vue({
    el: '#app'
});