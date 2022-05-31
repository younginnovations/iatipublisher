/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import {createApp} from 'vue';
import VueSmoothScroll from 'vue3-smooth-scroll';
import SvgVue from 'svg-vue3';
import WebHeader from './views/web/partials/WebHeader.vue';
import WebFooter from './views/web/partials/WebFooter.vue';
import WelcomeSignIn from './views/web/WelcomePage.vue';
import RegisterPage from './views/web/RegisterPage.vue';

/**
 * Vue components for Activities Listing
 *
 */
import StaticDescriptionForm from './components/DescriptionForm.vue';
import ElementsNote from './views/activity/partials/ElementsNote.vue';
import Activity from './views/activity/ActivityIndex.vue';
import LoggedInHeader from './components/AdminHeader.vue';
import ActivitiesDetail from './views/activity/ActivityDetail.vue';

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
 * Organisation data
 */
 import OrganisationData from './views/organisation/OrganisationData.vue';

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

app.component('WebHeader', WebHeader);
app.component('WebFooter', WebFooter);
app.component('WelcomeSignin', WelcomeSignIn);
app.component('RegisterForm', RegisterPage);

/**
 * Registering vue component for activity listing
 */
app.component('ActivityTemplate', Activity);
app.component('LoggedinHeader', LoggedInHeader);
app.component('ActivitiesDetail', ActivitiesDetail);
app.component('DescriptionForm', StaticDescriptionForm);
app.component('ElementsNote', ElementsNote);

/*
setting page
*/
app.component('SettingPage', SettingPage);
/*
Registering vue component for password reset
*/
app.component('ResetPage', ResetPage);
app.component('PasswordRecovery', PasswordRecovery);
app.component('ResetPassword', ResetPassword);

/**
 * Registering Additional Components
 */
app.component('HoverText', HoverText);

/**
 * Organisation data
 */
app.component('organisation-data', OrganisationData);

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
