import userRequestsService from "../../services/userRequestsService";
import * as types from "./types";

export default {
	async getRequests({ commit, state }) {
		const response = await userRequestsService.getRequests(
			state.filter,
			state.meta.page,
		);

		commit(types.SET_REQUESTS, {
			requests: response.data,
		});
		commit(types.SET_META, response.meta);
	},

	async updateRequest({ commit, dispatch }, request) {
		const response = await userRequestsService.updateRequest(request.id, request);

		commit(types.UPDATE_REQUEST, {
			request: response.data,
		});

		if (request.publish) {
			dispatch('questions/createQuestion', request, { root: true });
		}
	},

	async changeFilter({ commit, dispatch }, { filter, value }) {
		commit(types.CHANGE_FILTER, { filter, value });
		commit(types.SET_PAGE, 1);
		await dispatch('getRequests');
	},

	async assignRequest({ commit }, { requestId, userId }) {
		const response = await userRequestsService.assignResponsible(
			requestId,
			userId
		);

		commit(types.UPDATE_REQUEST, {
			request: response.data,
		});
	},

	async nextPage({ commit, state, dispatch }) {
		commit(types.SET_PAGE, state.meta.page + 1);
		await dispatch('getRequests');
	},

	async prevPage({ commit, state, dispatch }) {
		commit(types.SET_PAGE, state.meta.page - 1);
		await dispatch('getRequests');
	}
};