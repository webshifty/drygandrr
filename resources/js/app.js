require('./bootstrap');
require('alpinejs');

const Vuex = require('vuex');
const initialState = require('./store/').default;

Vue.use(Vuex);

Vue.component('Questions', require('./views/Questions').default);
Vue.component('Requests', require('./views/Requests').default);
Vue.component('Settings', require('./views/Settings').default);
Vue.component('Workers', require('./views/Workers').default);

const store = new Vuex.Store(initialState);

const app = new Vue({
	el: '#app',
	store,
 });
