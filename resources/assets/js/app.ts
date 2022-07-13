/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { createApp } from 'vue';
import VueSmoothScroll from 'vue3-smooth-scroll';
import SvgVue from 'svg-vue3';
import WebHeader from './views/web/partials/WebHeader.vue';
import WebFooter from './views/web/partials/WebFooter.vue';
import WelcomeSignIn from './views/web/WelcomePage.vue';
import RegisterPage from './views/web/RegisterPage.vue';

/**
 * Vue components for Activities Listing
 */
import ResultDetail from './views/activity/results/ResultDetail.vue';
import ResultList from './views/activity/results/ResultList.vue';
import IndicatorDetail from './views/activity/indicators/IndicatorDetail.vue';
import IndicatorList from './views/activity/indicators/IndicatorList.vue';
import PeriodsDetail from './views/activity/periods/PeriodsDetail.vue';
import PeriodsList from './views/activity/periods/PeriodsList.vue';
import TransactionList from './views/activity/transactions/TransactionList.vue';
import TransactionDetail from './views/activity/transactions/TransactionDetail.vue';
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
 import OrganisationDetail from './views/organisation/OrganisationDetail.vue';

/**
 * Additional Components
 */
import HoverText from './components/HoverText.vue';
import PageTitle from './components/sections/PageTitle.vue';

const app = createApp({});

/**
 * Global Components
 */

app
  .component('WebHeader', WebHeader)
  .component('WebFooter', WebFooter)
  .component('WelcomeSignin', WelcomeSignIn)
  .component('RegisterForm', RegisterPage);

/**
 * Registering vue component for activity listing
 */
app
  .component('ActivityTemplate', Activity)
  .component('LoggedinHeader', LoggedInHeader)
  .component('ActivitiesDetail', ActivitiesDetail)
  .component('DescriptionForm', StaticDescriptionForm)
  .component('ElementsNote', ElementsNote)
  .component('ResultDetail', ResultDetail)
  .component('ResultList', ResultList)
  .component('IndicatorDetail', IndicatorDetail)
  .component('IndicatorList', IndicatorList)
  .component('PeriodsDetail', PeriodsDetail)
  .component('PeriodsList', PeriodsList)
  .component('TransactionList', TransactionList)
  .component('TransactionDetail', TransactionDetail);

/*
 * Setting page
 */
app.component('SettingPage', SettingPage);
/*
Registering vue component for password reset
*/
app
  .component('ResetPage', ResetPage)
  .component('PasswordRecovery', PasswordRecovery)
  .component('ResetPassword', ResetPassword);

/**
 * Registering Additional Components
 */
app.component('HoverText', HoverText);
app.component('PageTitle', PageTitle);

/**
 * Organisation data
 */
app.component('OrganisationData', OrganisationData);
app.component('OrganisationDetail', OrganisationDetail);

/**
 * Extension to inline SVG files with Vue.js and optimize them automatically with SVGO
 */
app.use(SvgVue);

app.use(VueSmoothScroll);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
app.mount('#app');
