
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
Vue.component('app-searchbar', require('./components/Searchbar.vue'));
Vue.component('app-register', require('./components/Register.vue'));
Vue.component('app-account-details', require('./components/AccountDetails.vue'));
Vue.component('app-account-contact', require('./components/AccountContact.vue'));
Vue.component('app-account-company', require('./components/AccountCompany.vue'));
Vue.component('app-profile', require('./components/Profile.vue'));
Vue.component('app-contacts', require('./components/Contacts.vue'));
Vue.component('app-formats', require('./components/Formats.vue'));
Vue.component('app-categories', require('./components/Categories.vue'));
Vue.component('app-businesses', require('./components/Businesses.vue'));
Vue.component('app-show-company', require('./components/ShowCompany.vue'));

export const eventBus = new Vue();

/**
 * Vue constructor
 */
const app = new Vue({
    el: '#app'
});