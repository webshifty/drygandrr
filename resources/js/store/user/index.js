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
			defaultPhoto: userInfo.profile_photo_url || '/img/profile_photo.png',
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
			if (state.photo) {
				return window.__PAGE_STATE__.storage + '/' + state.photo;
			}

			return state.defaultPhoto;
		}
	}
};