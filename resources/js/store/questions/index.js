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
		}
	}),
	actions,
	mutations,
	getters,
};