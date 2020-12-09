import workerService from '../../services/workerService';
import * as types from './types';

export default {
	[types.SET_WORKERS]: (state, workers) => {
		state.workers = workers.map(workerService.mapWorker);
	}
};
