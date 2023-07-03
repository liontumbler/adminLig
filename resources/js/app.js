import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
import 'bootstrap-icons/font/bootstrap-icons.css';

import { createApp } from 'vue';
import login from '../components/login.vue';
import ligas from '../components/ligas.vue';
import navSidebar from '../components/navSidebar.vue';
import nav from '../components/nav.vue';

const app = createApp({});
app.component('login-component', login);
app.component('liga-component', ligas);
app.mount('#app');

const appNav = createApp({});
appNav.component('nav-sidebar', navSidebar);
appNav.component('nav-component', nav);
appNav.mount('#nav');

