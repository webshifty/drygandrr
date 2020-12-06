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

	async updateRequest({ commit, dispatch }, request) {
		const response = await userRequestsService.updateRequest(request.id, request);

		commit(UPDATE_REQUEST, {
			request: response.data,
		});

		if (request.publish) {
			dispatch('questions/createQuestion', request, { root: true });
		}
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(CHANGE_FILTER, { filter, value });

		await dispatch('getRequests');
	},

	async assignRequest({ commit }, { requestId, userId }) {
		const response = await userRequestsService.assignResponsible(
			requestId,
			userId
		);

		commit(UPDATE_REQUEST, {
			request: response.data,
		});
	}
};