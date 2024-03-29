
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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

Vue.component('tab-boards',require('./components/tabBoards.vue').default);
Vue.component('card-list',require('./components/CardList.vue').default);
Vue.component('application-component',require('./components/Application.vue').default);
Vue.component('tasks-list', require('./components/Tasks.vue').default); 
Vue.component('add-task', require('./components/AddTask.vue').default); 
Vue.component('delete-task', require('./components/deleteTaskButton.vue').default); 
Vue.component('task-component', require('./components/TaskComponent.vue').default);
Vue.component('update-task', require('./components/UpdateTaskButton.vue').default); 
Vue.component('card-component', require('./components/CardComponent.vue').default);
Vue.component('card-add', require('./components/CardAdd.vue').default);
Vue.component('board-add', require('./components/BoardAdd.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.prototype.$eventHub = new Vue(); // Global event bus
const app = new Vue({
    el: '#app', 
});
