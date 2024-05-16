/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'
import App from "./App.vue"
import ExampleComponent from './components/ExampleComponent.vue';
import HeaderComponent from './components/HeaderComponent.vue'
import Workspace from './components/Workspace.vue'
import DashboardComponent from "./components/DashboardComponent.vue"
import {myMixin} from './mixin.js'
import mitt from 'mitt';
import Vue3ProgressBar from 'vue3-progress-bar'

// import { createVfm } from 'vue-final-modal'

// import VModal from 'vue-js-modal'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp(App);

const EventBus = mitt();

const routes = [
    { path: '/home', component: DashboardComponent },
    { path: '/cotisation', component: DashboardComponent },
    { path: '/projet', component: DashboardComponent },
    // { path: '/home', component: App },
    // { path: '/home', component: App },
  ]

const router = createRouter({
    // 4. Provide the history implementation to use. We
    // are using the hash history for simplicity here.
    history: createWebHistory(),
    routes, // short for `routes: routes`
  })


app.component('example-component', ExampleComponent);
app.component('header-component', HeaderComponent);
app.component('workspace-component', Workspace);
app.component('dashboard-component', DashboardComponent);



app.provide('EventBus',EventBus);

app.use(router)
app.use(Vue3ProgressBar, {
  color: '#4f99ad',
  failedColor: 'red',
  successColor: 'green',
  height: '10px'
})
app.mixin(myMixin);
// app.use(VModal)
app.mount('#app');
