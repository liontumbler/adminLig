<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:" @click="abrirCerrarSidebar">
                <img :src="logo" class="imgIco" alt="Nocarga" height="52">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <li :class="btn.class" v-for="(btn, i) in btnsnavReal" :key="i">
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

    <div ref="sidebar" class="d-flex flex-column flex-shrink-0 ps-3 pe-3 pb-3 text-white bg-dark h-100 position-fixed pt-94px w-280px index-1" v-if="sidebar">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i :class="icontitleSide"></i>
            &nbsp;
            <span class="fs-4">{{ titleSide }}</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item" v-for="(btn, i) in btnssidebar" :key="i">
                <a :href="btn.href" class="nav-link text-white btn btn-light" aria-current="page">
                    <i :class="btn.icon"></i>
                    {{ btn.nombre }}
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img v-if="imgPerfil" src="imgPerfil" alt="" width="32" height="32"
                    class="rounded-circle me-2">
                <strong>{{ nombreUser }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li v-for="(btn, i) in footersidebar" :key="i">
                    <a class="dropdown-item" :href="btn.href">{{ btn.nombre }}</a>
                </li>
                <li v-if="footersidebar.length > 0">
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" :href="cerrarsesion">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: 'sidebar',
    props: {
        color: {
            type: String,
            default: '',
        },
        background: {
            type: String,
            default: '',
        },
        nombregimnasio: {
            type: String,
            default: '',
        },
        nombreperfil: {
            type: String,
            default: '',
        },
        btnssidebar: {
            type: Array,
            default: [],
        },
        footersidebar: {
            type: Array,
            default: [],
        },
        btnsnav: {
            type: Array,
            default: [],
        },
        cerrarsesion: {
            type: String,
            default: '/',
        },
    },
    mounted() {
        this.btnsnavReal = this.btnsnav.map(function(btn) {
            if (!Array.isArray(btn.href)) {
                return {nombre: btn.nombre, href: btn.href, class: 'nav-item'};
            }else if (Array.isArray(btn.href)) {
                return {nombre: btn.nombre, href: btn.href, class: 'nav-item dropdown'};
            }
        });
        console.log(this.color, this.background);
        if (this.color) {
            this.cadenaStyle = 'color:'+ this.color + ' !important;';
        }
        if (this.background) {
            this.cadenaStyle += 'background-color:'+ this.background + ' !important;';
        }
        if (this.nombregimnasio) {
            this.titleSide = this.nombregimnasio
        }
        if (this.nombreperfil) {
            this.nombreUser = this.nombreperfil;
        }
        var element = document.querySelector('.bg-dark');
        element.style.cssText = this.cadenaStyle;
    },
    data() {
        return {
            imgPerfil: null,
            icontitleSide: 'bi bi-bootstrap',
            titleSide: 'SideBar',
            nombreUser: 'Default',
            sidebar: false,
            logo: 'img/adminLig.svg',
            searchNav: false,
            btnsnavReal: [],
            cadenaStyle: '',
        }
    },
    methods: {
        abrirCerrarSidebar(e) {
            this.sidebar = !this.sidebar;

            this.$nextTick(() => {
                const elemento = this.$refs.sidebar;
                if (elemento) {
                    elemento.style.cssText = this.cadenaStyle;
                }
            });
        }
    },
};
</script>
<style>
.btn:hover {
    color: var(--bs-btn-hover-color) !important;
}
.text-white{
    --bs-text-opacity: none;
}
.navbar-dark, .navbar[data-bs-theme=dark]{
    --bs-navbar-color: none;
    --bs-navbar-active-color: none;
}
</style>

