/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import IpsComponent from "./components/IpsComponent";

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('ips-component', IpsComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data: {
        ips: {},
        ip: '',
        id_ip_address: '',
        cidr_size: 0,
        start_point: 0,
        limit: 10,
    },

    methods: {

        fetchIps: function () {
            axios.get('/subnet/' + this.id_ip_address + '/' + this.start_point)
                .then((response) => {

                    this.ips = response.data;

                    this.start_point += 10;

                });
        },

        load: function () {

            this.start_point += 10;
            axios.get('/subnet/' + this.id_ip_address + '/' + this.start_point)
                .then((response) => {
                    if (response.data.length === 0)
                        alert("no data more");
                    else
                        response.data.filter(this.pushIp);
                });

        },

        pushIp(value) {
            this.ips.push(value);
        }

    },

    mounted() {
        console.log("js file loaded");
        this.ip = document.getElementById('ip').value;
        this.id_ip_address = document.getElementById('id_subnet_ip').innerHTML;
        this.cidr_size = document.getElementById('cidr_size').value;
        this.fetchIps();
    }

});
