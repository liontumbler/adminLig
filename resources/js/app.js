import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
import 'bootstrap-icons/font/bootstrap-icons.css';

import { createApp } from 'vue';
import login from '../components/views/login.vue';
import ligas from '../components/views/ligas.vue';
import navSidebar from '../components/component/navSidebar.vue';
import nav from '../components/component/nav.vue';
import cliente from '../components/views/cliente.vue';
import gimnasio from '../components/views/gimnasio.vue';
import equipo from '../components/views/equipo.vue';
import descuento from '../components/views/descuento.vue';
import horaliga from '../components/views/horaliga.vue';

const app = createApp({});
app.component('login-component', login);
app.component('liga-component', ligas);
app.component('nav-sidebar', navSidebar);
app.component('nav-component', nav);
app.component('cliente-component', cliente);
app.component('gimnasio-component', gimnasio);
app.component('equipo-component', equipo);
app.component('descuento-component', descuento);
app.component('horaliga-component', horaliga);
app.mount('#app');
