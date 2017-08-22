
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
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('register', require('./components/Register.vue'));
Vue.component('contact-details', require('./components/ContactDetails.vue'));
Vue.component('company-details', require('./components/CompanyDetails.vue'));
Vue.component('contacts', require('./components/Contacts.vue'));

Vue.component('app-formats', require('./components/Formats.vue'));
Vue.component('app-categories', require('./components/Categories.vue'));

export const eventBus = new Vue();

/**
 * Vue constructor
 */
const app = new Vue({
    el: '#app'
});