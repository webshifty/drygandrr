import actions from './actions';
import mutations from './mutations';
import getters from './getters';

export default {
	namespaced: true,
	state: () => ({
		questions: [],
		filter: {
			country: '',
			category: '',
			search: '',
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