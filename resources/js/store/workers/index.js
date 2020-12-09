import mutations from './mutations';
import actions from './actions';

export default {
	namespaced: true,
	state: () => ({
		workers: [],
		workersByCountry: [],
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
	},
	actions,
	mutations,
};