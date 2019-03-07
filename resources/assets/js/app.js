
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./bootstrap-slider');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('paginate', require('vuejs-paginate'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));
/*
Vue.component('clip-component', require('./components/ClipComponent.vue'));
Vue.component('clip-new-component', require('./components/ClipNewComponent.vue'));
Vue.component('clip-show-component', require('./components/ClipShowComponent.vue'));
Vue.component('clip-edit-component', require('./components/ClipEditComponent.vue'));
Vue.component('clip-sort-component', require('./components/ClipSortComponent.vue'));
*/

Vue.component('channel-component', require('./components/ChannelComponent.vue'));
Vue.component('channel-show-component', require('./components/ChannelShowComponent.vue'));
Vue.component('cliplist-play-component', require('./components/CliplistPlayComponent.vue'));
Vue.component('cliplist-edit1-component', require('./components/CliplistEdit1Component.vue'));
Vue.component('cliplist-edit2-component', require('./components/CliplistEdit2Component.vue'));
Vue.component('cliplist-edit3-component', require('./components/CliplistEdit3Component.vue'));

/*
const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/funpage/:id', component: require('./components/FunpageComponent.vue') },
    ]
});
*/

const app = new Vue({
    el: '#app'
});
/*
const funpage = new Vue({
    el: '#funpage',
    monted() {
        var url = '/api/funpage/:id'
    }
});
*/