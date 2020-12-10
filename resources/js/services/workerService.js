import requestService from '../services/requestService';

export default {
	async getWorkers(filter) {
		return await requestService.get('/api/workers', {
			'filter[country]': filter.country,
			'filter[search]': filter.search,
		});
	},

	async getRequests(workerId) {
		return await requestService.get('/api/workers/' + workerId + '/requests');
	},

	async getWorker(workerId) {
		return await requestService.get('/api/workers/' + workerId);
	},

	async uploadPhoto(workerId, file) {
		return await requestService.file('/api/workers/' + workerId + '/photo', file);
	},

	async deletePhoto(workerId) {
		return await requestService.delete('/api/workers/' + workerId + '/photo');
	},

	async deleteWorker(workerId) {
		return await requestService.delete('/api/workers/' + workerId);
	},

	async updateWorker(worker) {
		return await requestService.put('/api/workers/' + worker.id, worker);
	},

	async getWorkerList() {
		return await requestService.get('/api/workers/list');
	},

	mapWorker(worker) {
		return {
			id: worker.id,
			name: worker.name,
			email: worker.email,
			country: worker.country,
			countryName: worker.countryName,
			requests_count: worker.requests_count,
			photo: worker.photo,
			is_operator: worker.is_operator,
			is_admin: worker.is_admin,
		};
	},

	mapWorkerListItem(worker) {
		return {
			id: worker.id,
			name: worker.name,
			country: worker.country,
		};
	}
};
