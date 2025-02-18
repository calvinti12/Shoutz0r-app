import Vue from "vue";
import VueBus from 'vue-bus';
import VueTablerIcons from 'vue-tabler-icons';
import router from "./router/app";
import store from "./store";
import Shoutzor from "./plugin/Shoutzor";
import App from "@js/views/App";

//Recursively scan and add all Vue components
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Create our Vue instance
const app = new Vue({
    components: {App},
    router,
    store
});

Vue.use(VueTablerIcons);
Vue.use(VueBus);
Vue.use(Shoutzor);

app.$mount('#shoutzor');

//Load other components
require('./bootstrap');
