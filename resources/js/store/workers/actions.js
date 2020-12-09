import workerService from '../../services/workerService';
import * as types from './types';

export default {
	async getWorkers({ commit }) {
		const response = await workerService.getWorkers();

		commit(types.SET_WORKERS, response?.data?.data);
	}
};