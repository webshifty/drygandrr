import requestService from '../services/requestService';

export default {
	async getWorkers(filter) {
		return await requestService.get('/api/workers', {
			'filter[country]': filter.country,
			'filter[search]': filter.search,
		});
	},

	mapWorker(worker) {
		return {
			id: worker.id,
			name: worker.name,
			email: worker.email,
			country: worker.country,
			countryName: worker.countryName,
			requests_count: worker.requests_count,
		};
	}
};
