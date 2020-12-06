import actions from './actions';
import mutations from './mutations';
import getters from './getters';

export default {
	namespaced: true,
	state: () => ({
		requests: [],
		filter: {
			search: '',
		}
	}),
	actions,
	mutations,
	getters,
};