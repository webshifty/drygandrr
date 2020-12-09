import mutations from './mutations';
import actions from './actions';

export default {
	namespaced: true,
	state: () => ({
		workers: [],
		workersByCountry: [],
		meta: {
			total: 0,
		},
		filter: {
			country: '',
			search: '',
		},
		requestsByWorkerId: {},
		worker: {},
	}),
	getters: {
		workers: state => state.workers,
		workersByCountry: state => {
			return state.workers.reduce((hash, worker) => {
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