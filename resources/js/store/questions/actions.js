import questionService from "../../services/questionService";
import {
	SET_QUESTIONS,
	ADD_QUESTION,
	UPDATE_QUESTION,
	DELETE_QUESTION,
	CHANGE_FILTER,
} from "./types";

export default {
	async getQuestions({ commit, state }) {
		const response = await questionService.getQuestions(
			state.filter
		);

		commit(SET_QUESTIONS, {
			questions: response.data,
		});
	},

	async createQuestion({ commit }, question) {
		const response = await questionService.createQuestion(question);

		commit(ADD_QUESTION, {
			question: response.data,
		});
	},

	async updateQuestion({ commit }, question) {
		const response = await questionService.updateQuestion(question.id, question);

		commit(UPDATE_QUESTION, {
			question: response.data,
		});
	},

	async deleteQuestion({ commit }, questionId) {
		await questionService.deleteQuestion(questionId);

		commit(DELETE_QUESTION, questionId);
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(CHANGE_FILTER, { filter, value });

		await dispatch('getQuestions');
	}
};