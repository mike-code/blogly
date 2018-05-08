
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import AtComponents from 'at-ui';
import VueRouter from 'vue-router';
import wysiwyg from "vue-wysiwyg";

Vue.use(VueRouter);
Vue.use(AtComponents);
Vue.use(wysiwyg, {});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('blog-entries', require('./components/BlogEntries.vue'));
Vue.component('blog-header', require('./components/BlogHeader.vue'));
Vue.component('at-modal-extended', require('./components/AtExtensions/AtModalExtended.vue'));
Vue.component('at-timeline-item-extended', require('./components/AtExtensions/AtTimelineItemExtended.vue'));

const app = new Vue({
    el: '#app'
});
