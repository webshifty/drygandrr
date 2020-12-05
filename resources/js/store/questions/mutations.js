import questionService from "../../services/questionService";
import {
	SET_QUESTIONS,
	ADD_QUESTION,
	UPDATE_QUESTION,
	DELETE_QUESTION,
	CHANGE_FILTER,
} from "./types";

export default {
	[SET_QUESTIONS]: (state, { questions }) => {
		state.questions = questions.map(questionService.mapQuestion);
	},

	[ADD_QUESTION]: (state, { question }) => {
		state.questions = [
			questionService.mapQuestion(question),
			...state.questions
		];
	},
	
	[UPDATE_QUESTION]: (state, { question }) => {
		const questionIndex = state.questions.findIndex(({ id }) => id === question.id);

		if (questionIndex === -1) {
			return;
		}

		state.questions = [
			...state.questions.slice(0, questionIndex),
			questionService.mapQuestion(question),
			...state.questions.slice(questionIndex + 1),
		];
	},

	[DELETE_QUESTION]: (state, questionId) => {
		state.questions = state.questions.filter(({ id }) => id !== questionId);
	},

	[CHANGE_FILTER]: (state, { filter, value }) => {
		state.filter = {
			...state.filter,
			[filter]: value,
		};
	}
};
