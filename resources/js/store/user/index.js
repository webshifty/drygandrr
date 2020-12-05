export default {
	namespaced: true,
	state: () => ({
		id: 1,
		country: 'Австрія',
		photo: '/img/profile_photo.png',
		name: 'Іван Іванов',
		email: 'ivan@mail.com'
	}),
	mutations: {},
	actions: {},
	getters: {
		user(state) {
			return state;
		}
	}
};