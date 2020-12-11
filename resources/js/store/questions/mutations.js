import questionService from "../../services/questionService";
import * as types from "./types";

export default {
	[types.SET_QUESTIONS]: (state, { questions }) => {
		state.questions = questions.map(questionService.mapQuestion);
	},

	[types.ADD_QUESTION]: (state, { question }) => {
		state.questions = [
			questionService.mapQuestion(question),
			...state.questions
		];
	},
	
	[types.UPDATE_QUESTION]: (state, { question }) => {
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

	[types.DELETE_QUESTION]: (state, questionId) => {
		state.questions = state.questions.filter(({ id }) => id !== questionId);
	},

	[types.CHANGE_FILTER]: (state, { filter, value }) => {
		state.filter = {
			...state.filter,
			[filter]: value,
		};
	},

	[types.SET_META]: (state, { total, per_page, current_page, last_page }) => {
		state.meta = {
			total: total,
			page: current_page,
			per_page: per_page,
			last_page: last_page,
		};
	},

	[types.SET_PAGE]: (state, page) => {
		state.meta = {
			...state.meta,
			page,
		};
	},
};
