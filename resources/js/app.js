import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
import 'bootstrap-icons/font/bootstrap-icons.css';

import { createApp } from 'vue';
import login from '../components/views/login.vue';
import ligas from '../components/views/ligas.vue';
import navSidebar from '../components/component/navSidebar.vue';
import nav from '../components/component/nav.vue';

const app = createApp({});
app.component('login-component', login);
app.component('liga-component', ligas);
app.component('nav-sidebar', navSidebar);
app.component('nav-component', nav);
app.mount('#app');
