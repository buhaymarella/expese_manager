import './bootstrap';
import { createApp } from 'vue';
import 'chartkick/chart.js';
import VueChartkick from 'vue-chartkick';
import axios from 'axios';
import VueAxios from 'vue-axios';
import router from './components/router';
import App from './components/App.vue';




const app = createApp(App);

app.use(VueAxios, axios);
app.use(router);

app.use(VueChartkick);

app.mount('#app');
