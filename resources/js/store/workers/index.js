import mutations from './mutations';
import actions from './actions';

export default {
	namespaced: true,
	state: () => ({
		worker: {},
		workers: [],
		workerList: [],
		workersByCountry: [],
		meta: {
			total: 0,
		},
		filter: {
			country: '',
			search: '',
		},
		requestsByWorkerId: {},
	}),
	getters: {
		workers: state => state.workers,
		workersByCountry: state => {
			return state.workerList.reduce((hash, worker) => {
				if (!hash[worker.country]) {
					hash[worker.country] = [];
				}

				hash[worker.country].push(worker);
				
				return hash;
			}, {});
		},
		countWorkers: state => state.meta.total,
		filter: state => state.filter,
		requestsByWorkerId: state => state.requestsByWorkerId,
		worker: state => state.worker,
	},
	actions,
	mutations,
};