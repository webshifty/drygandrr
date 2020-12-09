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

	async getRequests({ commit }, workerId) {
		const response = await workerService.getRequests(workerId);

		commit(types.SET_REQUESTS, {
			workerId,
			requests: response?.data?.data,
		});
	},

	async getWorker({ commit, state }, workerId) {
		const worker = state.workers.find(worker => worker.id === Number(workerId));
		
		if (worker) {
			commit(types.SET_WORKER, worker);
		}

		const response = await workerService.getWorker(workerId);

		commit(types.SET_WORKER, response?.data?.data);
	},

	async uploadPhoto({ commit }, { workerId, file }) {
		console.log('update photo');
	},

	async deletePhoto({ commit }, { workerId }) {
		console.log('delete photo');
	},

	async updateWorker({ commit }, worker) {
		console.log(worker);
	},

	async deleteWorker({ commit }, workerId) {
		console.log(workerId);
	}
};