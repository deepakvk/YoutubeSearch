/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VueYoutube from 'vue-youtube';
import Notifications from 'vue-notification';

import YoutubeDash from './Youtube/YoutubeDash.vue';
import VideoDetail from './Youtube/VideoDetail.vue';
import MyPlaylists from './Youtube/MyPlaylists.vue';

Vue.use(VueRouter);
Vue.use(VueYoutube);
Vue.use(Notifications);

window.eventBus = new Vue({});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const routes = [
    {path: '/', component: YoutubeDash, 'name': 'youtube-dash'},
    {path: '/video/:id', component: VideoDetail, 'name': 'youtube-video'},
    {path: '/playlists', component: MyPlaylists, 'name': 'my-playlist-page'}
];

const router = new VueRouter({
    routes
});

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('youtube-dashboard', require('./Youtube/YoutubeDash.vue').default);*/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    router
}).$mount('#app');
