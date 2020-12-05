const mutations = {
	SHOW_MODAL: 'SHOW_MODAL',
	HIDE_MODAL: 'HIDE_MODAL',
};

export default {
	namespaced: true,
	state: () => ({
		show: false,
		type: '',
		payload: {},
	}),
	actions: {
		showModal({ commit }, { type, payload }) {
			commit(mutations.SHOW_MODAL, { type, payload });
		},
		hideModal({ commit }) {
			commit(mutations.HIDE_MODAL);
		},
	},
	mutations: {
		[mutations.SHOW_MODAL]: (state, data) => {
			state.show = true;
			state.type = data.type;
			state.payload = data.payload;
		},
		[mutations.HIDE_MODAL]: (state, data) => {
			state.show = false;
			state.type = '';
			state.payload = {};
		},
	},
	getters: {
		show: state => state.show,
		type: state => state.type,
		payload: state => state.payload,
	}
};