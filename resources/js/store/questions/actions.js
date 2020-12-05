import questionService from "../../services/questionService";
import { SET_QUESTIONS, ADD_QUESTION, UPDATE_QUESTION } from "./types";

export default {
	async getQuestions({ commit }) {
		const response = await questionService.getQuestions();

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
	}
};