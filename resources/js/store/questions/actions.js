import questionService from "../../services/questionService";
import * as types from "./types";

export default {
	async getQuestions({ commit, state }) {
		const response = await questionService.getQuestions(
			state.filter,
			state.meta.page,
		);

		commit(types.SET_QUESTIONS, {
			questions: response.data,
		});
		commit(types.SET_META, response.meta);
	},

	async createQuestion({ commit }, question) {
		const response = await questionService.createQuestion(question);

		commit(types.ADD_QUESTION, {
			question: response.data,
		});
	},

	async updateQuestion({ commit }, question) {
		const response = await questionService.updateQuestion(question.id, question);

		commit(types.UPDATE_QUESTION, {
			question: response.data,
		});
	},

	async deleteQuestion({ commit }, questionId) {
		await questionService.deleteQuestion(questionId);

		commit(types.DELETE_QUESTION, questionId);
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(types.CHANGE_FILTER, { filter, value });
		commit(types.SET_PAGE, 1);

		await dispatch('getQuestions');
	},

	async nextPage({ commit, state, dispatch }) {
		commit(types.SET_PAGE, state.meta.page + 1);
		await dispatch('getQuestions');
	},

	async prevPage({ commit, state, dispatch }) {
		commit(types.SET_PAGE, state.meta.page - 1);
		await dispatch('getQuestions');
	}
};