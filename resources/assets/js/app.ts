/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { createApp } from 'vue';
import SvgVue from 'svg-vue3';

/**
 * Vue components for Activities Listing
 *
 */
import Activity from './components/activity/Activity.vue';
import LoggedInHeader from './components/Header.vue';

const app = createApp({});

/**
 * Registering vue component for activity listing
 */
app.component('activity-template', Activity);
app.component('loggedin-header', LoggedInHeader);

/**
 * Extension to inline SVG files with Vue.js and optimize them automatically with SVGO
 */
app.use(SvgVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

app.mount('#app');
