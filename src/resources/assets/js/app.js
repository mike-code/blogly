require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';
import AtComponents from 'at-ui';
import VueRouter from 'vue-router';

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(AtComponents);
Vue.component('inject-api-routes', require('./components/ApiRoutesInjector.vue'))

Vue.component('vue-app', require('./components/App.vue'))
Vue.component('blog-entries', require('./components/BlogEntries.vue'))
Vue.component('blog-header', require('./components/BlogHeader.vue'))
Vue.component('at-modal-extended', require('./components/AtExtensions/AtModalExtended.vue'))
Vue.component('at-timeline-item-extended', require('./components/AtExtensions/AtTimelineItemExtended.vue'))
Vue.component('blogly-login', require('./components/Modals/Login.vue'))

const store = new Vuex.Store(
{
    state:
    {
        user_data: null,
        login_modal_visible: false,
        blog_entry_modal_visible: false,
    },
    mutations:
    {
        set_blog_entry_modal(state, value)
        {
            state.blog_entry_modal_visible = value
        },
        set_login_modal(state, value)
        {
            state.login_modal_visible = value
        },
        set_api_routes(state, routes)
        {
            state.api_routes = routes;
        },
        set_user_data(state, data)
        {
            state.user_data = data
        }
    },
    actions:
    {
        getSessionData(context, app)
        {
            const loading = app.$Loading
            loading.start()

            axios.get(context.state.api_routes.session_data)
            .then(({data}) =>
            {
                context.commit('set_user_data', data.id ? data : null)
            })
            .finally(() =>
            {
                loading.finish()
            })
        }
    }
});

Vue.mixin(
{
    computed:
    {
        isLoggedIn()
        {
            return !!this.$store.state.user_data
        },
    }
})

const app = new Vue(
{
    el: '#app',
    store,
    created()
    {
        this.$Loading.config({width: 2})
    },
    mounted()
    {
        this.$store.dispatch('getSessionData', this)
    },
});
