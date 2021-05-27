require('./bootstrap');
import Vue from 'vue'

Vue.component('UniversityList', require('./components/university/List').default)

var app = new Vue({
    el: '#app',
})
