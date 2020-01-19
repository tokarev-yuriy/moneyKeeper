
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

Vue.filter('numberf', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'Rub',
        minimumFractionDigits: 0
    });
    return formatter.format(value);
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('planstat-component', require('./components/PlanstatComponent.vue').default);
Vue.component('wallettotal-component', require('./components/WallettotalComponent.vue').default);
Vue.component('plancategories-component', require('./components/PlancategoriesComponent.vue').default);


const app = new Vue({
    el: '#app'
});
