import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


//importaciones de componenetes VUE
// import SidebarVue from './components/layouts/Sidebar.vue';
// import AlertVue from './components/layouts/Alert.vue';
// import HeaderVue from './components/layouts/Header.vue';
// import GridVue from './components/videos/Grid.vue';
// import CommentVue from './components/videos/Comment.vue';
// import ClaseIndexVue from './components/clases/ClaseIndex.vue';
// import ClaseReserveVue from './components/clases/ClaseReserve.vue';
// import ClaseActionVue from './components/clases/ClaseAction.vue';
// import ClaseQuotaVue from './components/clases/ClaseQuota.vue';
// import ClaseAssistantVue from './components/clases/ClaseAssistant.vue';
// import ClaseNextVue from './components/clases/ClaseNext.vue';
// import ProfileComponentVue from './components/users/ProfileComponent.vue';
// import WodTodayVue from './components/wods/WodToday.vue';
// import StagesVue from './components/wods/Stages.vue';
// import PlansIndexVue from './components/plans/PlansIndex.vue';
// import PlansBuyVue from './components/plans/PlansBuy.vue';

// import Vue from 'vue'
// window.Vue = Vue;
// // require('./bootstrap');

// import moment from 'moment'
// window.moment = moment

// /**
//  * IMPORTS
//  */

// /**
//  * COMPONENT'S DEFINITIONS
//  */
// //layout
// Vue.component('sidebar-menu', SidebarVue.default);
// Vue.component('alert-toast', AlertVue.default);
// Vue.component('header-bar',HeaderVue.default);

// // Videos
// Vue.component('video-grid', GridVue.default);
// Vue.component('video-comment', CommentVue.default);

// // clases
// Vue.component('clase-index', ClaseIndexVue.default);
// Vue.component('clase-reserve', ClaseReserveVue.default);
// Vue.component('clase-action', ClaseActionVue.default);
// Vue.component('clase-quota', ClaseQuotaVue.default);
// Vue.component('clase-assistant', ClaseAssistantVue.default);
// Vue.component('clase-next', ClaseNextVue.default);

// // Settings
// Vue.component('profile-component', ProfileComponentVue.default);

// // WOds
// Vue.component('wod-today', WodTodayVue.default);
// Vue.component('stages', StagesVue.default);

// // Plans
// Vue.component('plans-index', PlansIndexVue.default);
// Vue.component('plans-buy', PlansBuyVue.default);


// // Vue.component('clases-test', require('./components/clases/Clases.vue').default);
// import store from './store.js'

// // Vue.component('v-date-range-picker', require('./components/DateRangePickerComponent.vue').default);

// /**
//  *  VUE GLOBAL INSTANCE
//  *
//  *  @type  {String}
//  */
new Vue({
    el: '#app',

    store,
});

