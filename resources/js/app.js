import { createPopper } from '@popperjs/core/dist/esm/popper';
window.createPopper = createPopper;

import 'bootstrap';
import { createApp } from 'vue';
import App from './App.vue';

const app = createApp(App);
app.mount('#app');