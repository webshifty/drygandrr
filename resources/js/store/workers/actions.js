import workerService from '../../services/workerService';
import * as types from './types';

export default {
	async getWorkers({ commit, state }) {
		const response = await workerService.getWorkers(state.filter, state.meta.page);

		commit(types.SET_WORKERS, response?.data?.data);
		commit(types.SET_META, response?.data?.meta );
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(types.CHANGE_FILTER, { filter, value });
		commit(types.SET_PAGE, 1);
		await dispatch('getWorkers');
	},

	async getRequests({ commit, state }, workerId) {
		const meta = state.metaByWorkerId[workerId] || { page: 1 };
		const response = await workerService.getRequests(workerId, meta.page);
		const data = response?.data;

		commit(types.SET_REQUESTS, {
			workerId,
			requests: data?.data,
		});
		commit(types.SET_META_BY_WORKER, { workerId, meta: data?.meta });
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
		const response = await workerService.uploadPhoto(workerId, file);
		
		commit(types.UPLOAD_PHOTO, response?.data?.data.photo);
	},

	async deletePhoto({ commit }, { workerId }) {
		const response = await workerService.deletePhoto(workerId);
		
		commit(types.UPLOAD_PHOTO, response?.data?.data.photo);
	},

	async updateWorker({ commit }, worker) {
		const response = await workerService.updateWorker(worker);

		commit(types.SET_WORKER, response?.data?.data);
	},

	async deleteWorker({ commit }, workerId) {
		await workerService.deleteWorker(workerId);

		commit(types.DELETE_WORKER, workerId);
	},

	async getWorkerList({ commit, state }) {
		const response = await workerService.getWorkerList();

		commit(types.SET_WORKER_LIST, response?.data?.data);
	},

	async nextPageByWorker({ commit, state, dispatch }, workerId) {
		const meta = state.metaByWorkerId[workerId] || { page: 1 };
		commit(types.SET_REQUEST_PAGE, { workerId, page: meta.page + 1 });
		await dispatch('getRequests', workerId);
	},

	async prevPageByWorker({ commit, state, dispatch }, workerId) {
		const meta = state.metaByWorkerId[workerId] || { page: 1 };
		commit(types.SET_REQUEST_PAGE, { workerId, page: meta.page - 1 });
		await dispatch('getRequests', workerId);
	},

	async nextPage({ commit, state, dispatch }) {
		commit(types.SET_PAGE, state.meta.page + 1);
		await dispatch('getWorkers');
	},

	async prevPage({ commit, state, dispatch }) {
		commit(types.SET_PAGE, state.meta.page - 1);
		await dispatch('getWorkers');
	}
};