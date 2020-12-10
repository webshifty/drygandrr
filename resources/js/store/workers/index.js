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
			page: 1,
			per_page: 20,
			last_page: 1,
		},
		filter: {
			country: '',
			search: '',
		},
		requestsByWorkerId: {},
		metaByWorkerId: {},
	}),
	getters: {
		workers: state => state.workers,
		meta: state => state.meta,
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
		metaByWorkerId: state => state.metaByWorkerId,
		worker: state => state.worker,
	},
	actions,
	mutations,
};