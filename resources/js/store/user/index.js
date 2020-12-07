import actions from './actions';
import mutations from './mutations';

export default {
	namespaced: true,
	state: () => {
		const userInfo = window.__PAGE_STATE__?.userInfo || {};

		return {
			id: userInfo.id,
			work_country: userInfo.work_country,
			country: userInfo?.country?.name || userInfo?.country?.name_ru || userInfo?.country?.name_en,
			access: userInfo.access,
			photo: userInfo.profile_photo_path,
			photoUrl: userInfo.profile_photo_url,
			name: userInfo.name,
			email: userInfo.email
		}
	},
	mutations,
	actions,
	getters: {
		user(state) {
			return state;
		},
		photo(state) {
			return state.photoUrl;
		},
		isAdmin(state) {
			return state.access === 7;
		}
	}
};