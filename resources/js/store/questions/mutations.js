import questionService from "../../services/questionService";
import { SET_QUESTIONS } from "./types";

export default {
	[SET_QUESTIONS]: (state, { questions }) => {
		state.questions = questions.map(questionService.mapQuestion);
	},
};
