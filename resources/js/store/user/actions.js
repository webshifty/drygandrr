import * as types from './types';
import requestService from '../../services/requestService';

export default {
	async uploadPhoto({ commit }, file) {
		const response = await requestService.file('/api/user/photo', file);

		commit(types.UPLOAD_PHOTO, response?.data?.data.photo);
	},

	async deletePhoto({ commit }) {
		await requestService.delete('/api/user/photo');
		
		commit(types.DELETE_PHOTO);
	}
}
