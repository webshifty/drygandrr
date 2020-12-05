require('./bootstrap');
require('alpinejs');
// require('./script.js');
const Vuex = require('vuex');
const initialState = require('./store/').default;

Vue.use(Vuex);

Vue.component('Questions', require('./views/Questions').default);
Vue.component('Requests', require('./views/Requests').default);

const store = new Vuex.Store(initialState);

const app = new Vue({
	el: '#app',
	store,
 });
