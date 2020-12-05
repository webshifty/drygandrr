const SHOW_ALERT = 'SHOW_ALERT';
const HIDE_ALERT = 'HIDE_ALERT';

export default {
	namespaced: true,
	state: () => ({
		show: false,
		type: '',
		message: '',
	}),
	getters: {
		isShown: state => state.show,

		alert: state => ({
			type: state.type,
			message: state.message,
		})
	},
	actions: {
		error({ commit }, { message }) {
			commit(SHOW_ALERT, { type: 'error', message });
		},
		hideAlert({ commit }) {
			commit(HIDE_ALERT);
		}
	},
	mutations: {
		[SHOW_ALERT]: (state, { type, message }) => {
			state.show = true;
			state.type = type;
			state.message = message;
		},
		[HIDE_ALERT]: (state) => {
			state.show = false;
			state.type = '';
			state.message = '';
		}
	}
};