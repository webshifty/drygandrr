import workerService from '../../services/workerService';
import userRequestsService from '../../services/userRequestsService';
import * as types from './types';

export default {
	[types.SET_WORKERS]: (state, workers) => {
		state.workers = workers.map(workerService.mapWorker);
	},
	[types.CHANGE_FILTER]: (state, { filter, value }) => {
		state.filter = {
			...state.filter,
			[filter]: value,
		};
	},
	[types.SET_META]: (state, { total, per_page, current_page, last_page }) => {
		state.meta = {
			total: total,
			page: current_page,
			per_page: per_page,
			last_page: last_page,
		};
	},
	[types.SET_PAGE]: (state, page) => {
		state.meta = {
			...state.meta,
			page,
		};
	},
	[types.SET_REQUESTS]: (state, { requests, workerId }) => {
		state.requestsByWorkerId = {
			...state.requestsByWorkerId,
			[workerId]: requests.map(userRequestsService.mapRequest),
		};
	},
	[types.SET_WORKER]: (state, worker) => {
		state.worker = workerService.mapWorker(worker);
	},
	[types.UPLOAD_PHOTO]: (state, photo) => {
		state.worker = {
			...state.worker,
			photo
		};
	},
	[types.DELETE_WORKER]: (state, workerId) => {
		state.worker = {};
		state.workers = state.workers.filter(worker => worker.id === workerId);
	},
	[types.SET_WORKER_LIST]: (state, workers) => {
		state.workerList = workers.map(workerService.mapWorkerListItem);
	},
	[types.SET_META_BY_WORKER]: (state, { workerId, meta }) => {
		state.metaByWorkerId = {
			...state.metaByWorkerId,
			[workerId]: {
				total: meta?.total || 0,
				page: meta?.current_page || 1,
				per_page: meta?.per_page || 20,
				last_page: meta?.last_page || 1,
			},
		};
	},
	[types.SET_REQUEST_PAGE]: (state, { workerId, page }) => {
		state.metaByWorkerId = {
			...state.metaByWorkerId,
			[workerId]: {
				...(state.metaByWorkerId[workerId] || {}),
				page,
			},
		};
	},
};
