import requestService from "./requestService";

export default {
	async getRequests(filter, page = 1) {
		const response = await requestService.get('/api/requests?page=' + page, {
			'filter[search]': filter.search,
			'filter[category]': filter.category,
			'filter[requests]': filter.requests,
			'filter[country]': filter.country,
		});

		return response?.data || { data: [], meta: {} };
	},
	async updateRequest(id, request) {
		const response = await requestService.put('/api/requests/' + id, request);

		return response?.data || {
			data: []
		};
	},
	async sendMessage(id, message) {
		return await requestService.put('/api/requests/' + id + '/respond', { message_text: message });
	},
	async assignResponsible(id, responsible) {
		const response = await requestService.put('/api/requests/' + id + '/responsible', {
			responsible,
		});

		return response?.data || {
			data: []
		};
	},
	mapRequest(request) {
		return {
			id: request.id,
			question: request.question,
			user: request.user,
			status: request.status,
			created_at: request.created_at,
			category: request.category,
			answer: request.answer,
			country: request.country,
			responsible: request.responsible,
		};
	},
};