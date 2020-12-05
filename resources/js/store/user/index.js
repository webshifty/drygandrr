export default {
	namespaced: true,
	state: () => {
		const userInfo = window.__PAGE_STATE__?.userInfo || {};

		return {
			id: userInfo.id,
			country: userInfo.country || 'Австрія',
			photo: userInfo.profile_photo_path || '/img/profile_photo.png',
			name: userInfo.name,
			email: userInfo.email
		}
	},
	mutations: {},
	actions: {},
	getters: {
		user(state) {
			return state;
		}
	}
};