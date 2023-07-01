<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:" @click="abrirCerrarSidebar">{{ logo }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <li :class="btn.class" v-for="(btn, i) in btnsNav" :key="i">
                        <div v-if="!Array.isArray(btn.href)">
                            <a class="nav-link active" :href="btn.href">{{ btn.nombre }}</a>
                        </div>
                        <div v-else-if="Array.isArray(btn.href)">
                            <a class="nav-link dropdown-toggle" href="javascript:" :id="'navbarDropdown'+ i" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ btn.nombre }}
                            </a>
                            <ul class="dropdown-menu" :aria-labelledby="'navbarDropdown'+ i">
                                <li v-for="(subbtn, e) in btn.href" :key="e">
                                    <div v-if="subbtn.nombre === 'divider'">
                                        <hr class="dropdown-divider">
                                    </div>
                                    <div v-else-if="subbtn.nombre != 'divider'">
                                        <a class="dropdown-item" :href="subbtn.href">{{ subbtn.nombre }}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="d-flex" role="search" v-if="searchNav">
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100 position-fixed p-68px" style="width: 280px;" v-if="sidebar">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i :class="icontitleSide"></i>
            &nbsp;
            <span class="fs-4">{{ titleSide }}</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item" v-for="(btn, i) in btnsSidebar" :key="i">
                <a :href="btn.href" class="nav-link text-white active" aria-current="page">
                    <i :class="btn.icon"></i>
                    {{ btn.nombre }}
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                    class="rounded-circle me-2">
                <strong>{{ nombreUser }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li v-for="(btn, i) in footerSidebar" :key="i">
                    <a class="dropdown-item" :href="btn.href">{{ btn.nombre }}</a>
                </li>
                <li v-if="footerSidebar.length > 0">
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" :href="cerrarSesion">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: 'navSidebar',
    mounted() {
        this.btnsNav = this.btnsNav.map(function(btn) {
            if (!Array.isArray(btn.href)) {
                return {nombre: btn.nombre, href: btn.href, class: 'nav-item'};
            }else if (Array.isArray(btn.href)) {
                return {nombre: btn.nombre, href: btn.href, class: 'nav-item dropdown'};
            }
        });
    },
    data() {
        return {
            icontitleSide: 'bi bi-bootstrap',
            titleSide: 'SideBar',
            nombreUser: 'Default',
            cerrarSesion: '',
            sidebar: false,
            btnsSidebar: [
                {nombre: 'home3', href: 'home3', icon: 'bi bi-house-door'},
                {nombre: 'home4', href: 'home4', icon: 'bi bi-house-door'},
            ],
            footerSidebar: [
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
            ],
            logo: 'Navbar',
            searchNav: false,
            btnsNav: [
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
                {nombre: 'dorp', href: [
                    {nombre: 'uno', href: 'uno'},
                    {nombre: 'divider'},
                    {nombre: 'dos', href: 'dos'}
                ]},
            ],
        }
    },
    methods: {
        abrirCerrarSidebar(e) {
            this.sidebar = !this.sidebar;
        }
    },
};
</script>

