import * as types from './types';

export default {
	[types.UPLOAD_PHOTO]: (state, photo) => {
		state.photo = photo;
	},

	[types.DELETE_PHOTO]: (state) => {
		state.photo = undefined;
	},
};
