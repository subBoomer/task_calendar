import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

require('./bootstrap');

import Vue from 'vue';
import Calendar from './components/Calendar.vue';

Vue.component('calendar', Calendar);

const app = new Vue({
    el: '#app',
});
