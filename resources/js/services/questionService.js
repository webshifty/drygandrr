import requestService from "./requestService";

export default {
	async getQuestions() {
		const response = await requestService.get('/api/questions');

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
			question: question.text,
			answer: question.answer,
		};
	}
};
