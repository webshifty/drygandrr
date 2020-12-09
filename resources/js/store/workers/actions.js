import workerService from '../../services/workerService';
import * as types from './types';

export default {
	async getWorkers({ commit, state }) {
		const response = await workerService.getWorkers(state.filter);

		commit(types.SET_WORKERS, response?.data?.data);
		commit(types.SET_META, { key: 'total', value: response?.data?.meta?.total || 0} );
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(types.CHANGE_FILTER, { filter, value });

		await dispatch('getWorkers');
	},
};