import requestService from '../../services/requestService';

const ADD_CATEGORY = 'ADD_CATEGORY';

export default {
	namespaced: true,
	state: () => ({
		routes: window.__PAGE_STATE__?.routes || {},
		routeName: window.__PAGE_STATE__?.routeName || '',
		countries: window.__PAGE_STATE__?.countries || [],
		categories: window.__PAGE_STATE__?.categories || [],
		statuses: window.__PAGE_STATE__?.statuses || [],
	}),
	getters: {
		routeName: state => state.routeName,
		routes: state => state.routes,
		countries: state => state.countries,
		categories: state => state.categories,
		statuses: state => state.statuses,
	},
	actions: {
		async addCategory({ commit }, category) {
			const response = await requestService.post('/api/categories', { category });

			commit(ADD_CATEGORY, response?.data?.data);
		}
	},
	mutations: {
		[ADD_CATEGORY]: (state, data) => {
			state.categories = [
				...state.categories,
				{
					id: data.id,
					name: data.name,
				},
			];
		},
	}
};