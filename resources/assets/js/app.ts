/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import {createApp} from 'vue';
import VueSmoothScroll from 'vue3-smooth-scroll';
import SvgVue from 'svg-vue3';
import ExampleComponent from './components/ExampleComponent.vue';
import WebHeader from './views/web/partials/WebHeader.vue';
import WebFooter from './views/web/partials/WebFooter.vue';
import WelcomeSignIn from './views/web/WelcomePage.vue';
import RegisterPage from './views/web/RegisterPage.vue';

/**
 * Vue components for Activities Listing
 *
 */
import Activity from './views/activity/Index.vue';
import LoggedInHeader from './components/AdminHeader.vue';
import ActivitiesDetail from './views/activity/Show.vue';
import StaticDescriptionForm from './components/DescriptionForm.vue';
import ElementsNote from './views/activity/partials/ElementsNote.vue';

/**
 * Setting page
 */
import SettingPage from './views/setting/SettingPage.vue';

/**
 * vue component for password reset
 */
import ResetPage from './views/reset/ResetPage.vue';
import PasswordRecovery from './views/reset/PasswordRecovery.vue';
import ResetPassword from './views/reset/ResetPassword.vue';

/**
 * Additional Components
 */
import HoverText from './components/HoverText.vue';

const app = createApp({});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

app.component('example-component', ExampleComponent);
app.component('web-header', WebHeader);
app.component('web-footer', WebFooter);
app.component('welcome-signin', WelcomeSignIn);
app.component('register-form', RegisterPage);

/**
 * Registering vue component for activity listing
 */
app.component('activity-template', Activity);
app.component('loggedin-header', LoggedInHeader);
app.component('activities-detail', ActivitiesDetail);
app.component('description-form', StaticDescriptionForm);
app.component('elements-note', ElementsNote);

/*
setting page
*/
app.component('setting-page', SettingPage);
/*
Registering vue component for password reset
*/
app.component('reset-page', ResetPage);
app.component('password-recovery', PasswordRecovery);
app.component('reset-password', ResetPassword);

/**
 * Registering Additional Components
 */
app.component('hover-text', HoverText);

/**
 * Extension to inline SVG files with Vue.js and optimize them automatically with SVGO
 */
app.use(SvgVue);

app.use(VueSmoothScroll)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
app.mount('#app');
