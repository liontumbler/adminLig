<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img :src="logo" class="imgIco" alt="Nocarga" height="52">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <li :class="btn.class" v-for="(btn, i) in btnsnav" :key="i">
                        <div v-if="!Array.isArray(btn.href)">
                            <a class="nav-link active text-blanco" :href="btn.href">{{ btn.nombre }}</a>
                        </div>
                        <div v-else-if="Array.isArray(btn.href)">
                            <a class="nav-link dropdown-toggle text-blanco" href="javascript:" :id="'navbarDropdown'+ i" role="button"
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
</template>
<script>
export default {
    name: 'nav',
    props: {
        logo: {
            type: String,
            default: '',
        },
    },
    mounted() {
        this.btnsnav = this.btnsnav.map(function(btn) {
            if (!Array.isArray(btn.href)) {
                return {nombre: btn.nombre, href: btn.href, class: 'nav-item'};
            }else if (Array.isArray(btn.href)) {
                return {nombre: btn.nombre, href: btn.href, class: 'nav-item dropdown'};
            }
        });
    },
    data() {
        return {
            searchNav: false,
            btnsnav: [
                {nombre: 'home', href: 'home'},
                {nombre: 'home2', href: 'home2'},
                {nombre: 'Opciones', href: [
                    {nombre: 'Administradores', href: '/loginAdmin'},
                    {nombre: 'Trabajadores', href: '/loginTrabajador'},
                    {nombre: 'divider'},
                    {nombre: 'PQRs', href: 'dos'}
                ]},
            ],
        }
    },
};
</script>

