require('./bootstrap');

import router from './router'
import { createApp } from 'vue'

//import Bootstrap, Popper, jQuery
import 'bootstrap/dist/css/bootstrap.css'
import 'jquery/dist/jquery.min'
import 'popper.js/dist/popper.min'
import 'bootstrap/dist/js/bootstrap.min'

const app = createApp({})

import {Form, Errors } from 'vform'
window.Form = Form;
app.component(Errors.name, Errors)

app.component('pagination', require('laravel-vue-pagination'));

import swal from 'sweetalert2';

window.swal = swal;


import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css'

app.use(ElementPlus)

import VuePictureSwipe from 'vue3-picture-swipe';
app.component('vue-picture-swipe', VuePictureSwipe);


app.use(router)

app.mount('#app')