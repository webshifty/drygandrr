import requestService from "./requestService";

export default {
	async getQuestions() {
		const response = await requestService.get('/api/questions');

		return response?.data || {
			data: []
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
