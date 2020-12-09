import requestService from '../services/requestService';

export default {
	async getWorkers() {
		return await requestService.get('/api/workers');
	},

	mapWorker(worker) {
		return {
			id: worker.id,
			name: worker.name,
			country: worker.country,
		};
	}
};
