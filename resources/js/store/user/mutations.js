import * as types from './types';

export default {
	[types.UPLOAD_PHOTO]: (state, photo) => {
		state.photo = photo;
	},

	[types.DELETE_PHOTO]: (state) => {
		state.photo = undefined;
	},

	[types.UPDATE_USER]: (state, user) => {
		state.work_country = user.work_country;
		state.country = user.country?.name || user.country?.name_ru || user.country?.name_en;
		state.access = user.access;
		state.name = user.name;
		state.email = user.email;
	},
};
