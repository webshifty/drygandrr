import questionService from "../../services/questionService";
import { SET_QUESTIONS } from "./types";

export default {
	async getQuestions({ commit }) {
		const response = await questionService.getQuestions();

		commit(SET_QUESTIONS, {
			questions: response.data,
		});
	}
};