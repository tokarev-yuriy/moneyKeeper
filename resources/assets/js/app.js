
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

/**
 *  @brief number_format function
 */
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
 *  @brief cut text function
 */
Vue.filter('cuttext', function (value) {
    if (value.length > 12) {
        value = value.substr(0,9);
        value = value + "...";
    }
    return value;
});

/**
 *  @brief Translate function
 */
Vue.filter('trans', function (value) {
    let codes = value.split('.');
    let translate = window.translations;
    
    for(var x in codes) {
        if (!translate || !translate[codes[x]]) {
            return value;
        }
        translate = translate[codes[x]];
    }
    
    return translate;
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('planstat-component', require('./components/PlanstatComponent.vue').default);
Vue.component('wallettotal-component', require('./components/WallettotalComponent.vue').default);
Vue.component('plancategories-component', require('./components/PlancategoriesComponent.vue').default);
Vue.component('operation-btns', require('./components/OperationBtns.vue').default);
Vue.component('operation-list', require('./components/OperationList.vue').default);
Vue.component('operation-sync-list', require('./components/OperationSyncList.vue').default);
Vue.component('operation-import-list', require('./components/OperationImportList.vue').default);
Vue.component('operation-edit', require('./components/OperationEdit.vue').default);
Vue.component('operation-filter', require('./components/OperationFilter.vue').default);
Vue.component('dropdown-items', require('./components/DropdownItems.vue').default);
Vue.component('multi-select', require('./components/MultiSelect.vue').default);
Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('plan-stat', require('./components/PlanStat.vue').default);

Vue.component('wallets-list', require('./components/WalletsList.vue').default);
Vue.component('wallets-edit', require('./components/WalletsEdit.vue').default);

Vue.component('categories-list', require('./components/CategoriesList.vue').default);
Vue.component('categories-edit', require('./components/CategoriesEdit.vue').default);

Vue.component('plans-list', require('./components/PlansList.vue').default);
Vue.component('plans-edit', require('./components/PlansEdit.vue').default);


const app = new Vue({
    el: '#app'
});
