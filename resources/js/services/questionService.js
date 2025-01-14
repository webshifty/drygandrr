import requestService from "./requestService";

export default {
	async getQuestions(filter, page = 1) {
		const response = await requestService.get('/api/questions?page=' + page, {
			'filter[category]': filter.category,
			'filter[country]': filter.country,
			'filter[search]': filter.search,
		});

		return response?.data || {
			data: [],
			meta: {},
		};
	},

	async createQuestion(question) {
		const response = await requestService.post('/api/questions', question);

		return response?.data || {
			data: []
		};
	},

	async updateQuestion(id, question) {
		const response = await requestService.put('/api/questions/' + id, question);

		return response?.data || {
			data: []
		};
	},

	async deleteQuestion(id) {
		await requestService.delete('/api/questions/' + id);
	},

	mapQuestion(question) {
		return {
			id: question.id,
			country: question.country,
			category: question.category,
			status: question.status,
			question: question.question,
			answer: question.answer,
			publish: question.publish,
		};
	}
};
