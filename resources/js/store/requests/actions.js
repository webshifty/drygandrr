import userRequestsService from "../../services/userRequestsService";
import {
	SET_REQUESTS,
	UPDATE_REQUEST,
	CHANGE_FILTER,
} from "./types";

export default {
	async getRequests({ commit, state }) {
		const response = await userRequestsService.getRequests(
			state.filter
		);

		commit(SET_REQUESTS, {
			requests: response.data,
		});
	},

	async updateRequests({ commit }, request) {
		const response = await userRequestsService.updateRequests(request.id, request);

		commit(UPDATE_REQUEST, {
			request: response.data,
		});
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(CHANGE_FILTER, { filter, value });

		await dispatch('getRequests');
	}
};