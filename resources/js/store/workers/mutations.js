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
	[types.SET_META]: (state, { key, value }) => {
		state.meta = {
			...state.meta,
			[key]: value,
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
	}
};
