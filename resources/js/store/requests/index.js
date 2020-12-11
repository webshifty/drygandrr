import actions from './actions';
import mutations from './mutations';
import getters from './getters';

export default {
	namespaced: true,
	state: () => ({
		requests: [],
		filter: {
			search: '',
			requests: 'my',
			category: '0',
			country: ''
		},
		meta: {
			total: 0,
			page: 1,
			per_page: 20,
			last_page: 1,
		}
	}),
	actions,
	mutations,
	getters,
};