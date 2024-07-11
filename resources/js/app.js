import './bootstrap';
import Alpine from 'alpinejs';
import Vue from 'vue/dist/vue.esm.js';
import VueLocalStorage from 'vue-local-storage';


//public vue compoenents
import PublicHeaderVue from './components/publicWeb/Header.vue';
import PublicHeroVue from './components/publicWeb/Hero.vue';
import PublicDisciplinesVue from './components/publicWeb/Disciplines.vue';
import PublicReservationsVue from './components/publicWeb/TestReservation/Reservation.vue';
import PublicPlansVue from './components/publicWeb/Memberships/Plans.vue';
import PublicAmenitiesVue from './components/publicWeb/Memberships/Amenities.vue';
import PublicContactVue from './components/publicWeb/Contact.vue';
import PublicMobileAppVue from './components/publicWeb/MobileApp.vue';
import PublicFooterVue from './components/publicWeb/Footer.vue';
import PublicFlotatingWhatsAppVue from './components/publicWeb/FlotatingWhatsApp.vue';

//public vue compoenents
import SidebarVue from './components/layouts/Sidebar.vue';
import AlertVue from './components/layouts/Alert.vue';
import HeaderVue from './components/layouts/Header.vue';
import GridVue from './components/videos/Grid.vue';
import CommentVue from './components/videos/Comment.vue';
import ClaseIndexVue from './components/clases/ClaseIndex.vue';
import ClaseReserveVue from './components/clases/ClaseReserve.vue';
import ClaseActionVue from './components/clases/ClaseAction.vue';
import ClaseQuotaVue from './components/clases/ClaseQuota.vue';
import ClaseAssistantVue from './components/clases/ClaseAssistant.vue';
import ClaseNextVue from './components/clases/ClaseNext.vue';
import ProfileComponentVue from './components/users/ProfileComponent.vue';
import WodTodayVue from './components/wods/WodToday.vue';
import StagesVue from './components/wods/Stages.vue';
import PlansIndexVue from './components/plans/PlansIndex.vue';
import PlansBuyVue from './components/plans/PlansBuy.vue';
import store from './store.js';


window.Alpine = Alpine;
Alpine.start();
window.Vue = Vue;
Vue.config.productionTip = false;
Vue.use(VueLocalStorage);


// Define your components
Vue.component('sidebar-menu', SidebarVue);
Vue.component('alert-toast', AlertVue);
Vue.component('header-bar', HeaderVue);
Vue.component('video-grid', GridVue);
Vue.component('video-comment', CommentVue);
Vue.component('clase-index', ClaseIndexVue);
Vue.component('clase-reserve', ClaseReserveVue);
Vue.component('clase-action', ClaseActionVue.default);
Vue.component('clase-quota', ClaseQuotaVue.default);
Vue.component('clase-assistant', ClaseAssistantVue.default);
Vue.component('clase-next', ClaseNextVue);
Vue.component('profile-component', ProfileComponentVue);
Vue.component('wod-today', WodTodayVue);
Vue.component('stages', StagesVue.default);
Vue.component('plans-index', PlansIndexVue);
Vue.component('plans-buy', PlansBuyVue.default);
//public vue compoenents
Vue.component('public-header', PublicHeaderVue);

// Create a new Vue instance
new Vue({
  el: '#app_2',
  store,
});
// new Vue({
//   render: h => h(HeaderVue),
//   store,
// }).$mount('#app_2');

new Vue({
  el: '#app_3',
  components : {
   'public-header': PublicHeaderVue,
   'public-hero': PublicHeroVue,
   'public-disciplines': PublicDisciplinesVue,
   'public-reservations': PublicReservationsVue,
   'public-plans': PublicPlansVue,
   'public-amenities': PublicAmenitiesVue,
   'public-contact': PublicContactVue,
   'public-mobile-app': PublicMobileAppVue,
   'public-footer': PublicFooterVue,
   'public-floating-whatsapp': PublicFlotatingWhatsAppVue,

  },

});