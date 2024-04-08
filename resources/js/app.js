import Calendar from '@toast-ui/vue-calendar';
import '@toast-ui/calendar/dist/toastui-calendar.min.css';
import Vue from 'vue/dist/vue.js';
import App from './App.vue';

/* eslint-disable no-new */
new Vue({
    el: '#app',
    components: { App },
    render: (h) => h(App),
  });