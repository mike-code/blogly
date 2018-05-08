require('./bootstrap');

import Vue from 'vue';
import AtComponents from 'at-ui';
import VueRouter from 'vue-router';
import wysiwyg from "vue-wysiwyg";

Vue.use(VueRouter);
Vue.use(AtComponents);
Vue.use(wysiwyg, {});

Vue.component('blog-entries', require('./components/BlogEntries.vue'));
Vue.component('blog-header', require('./components/BlogHeader.vue'));
Vue.component('at-modal-extended', require('./components/AtExtensions/AtModalExtended.vue'));
Vue.component('at-timeline-item-extended', require('./components/AtExtensions/AtTimelineItemExtended.vue'));
Vue.component('blogly-login', require('./components/Modals/Login.vue'));

const app = new Vue({
    el: '#app',
    mounted()
    {
        this.is_loggedin = (this.$el.attributes.loggedin.value == 1);
    },
    data:
    {
        is_loggedin: null,
        login_modal: null,
    }
});
