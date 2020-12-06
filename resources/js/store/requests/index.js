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
		}
	}),
	actions,
	mutations,
	getters,
};