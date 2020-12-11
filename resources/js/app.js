require('./bootstrap');
require('alpinejs');

const Vuex = require('vuex');
const VueRouter = require('vue-router').default;
const initialState = require('./store/').default;
const routes = require('./routes/').default;

Vue.use(Vuex);
Vue.use(VueRouter);

Vue.component('Questions', require('./views/Questions').default);
Vue.component('Requests', require('./views/Requests').default);
Vue.component('Settings', require('./views/Settings').default);
Vue.component('Workers', require('./views/Workers').default);
Vue.component('Public', require('./views/Public').default);

const store = new Vuex.Store(initialState);
const router = new VueRouter({
	routes
});

const app = new Vue({
	el: '#app',
	store,
	router,
 });
