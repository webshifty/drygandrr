import userRequestsService from "../../services/userRequestsService";
import * as types from "./types";

export default {
	[types.SET_REQUESTS]: (state, { requests }) => {
		state.requests = requests.map(userRequestsService.mapRequest);
	},
	
	[types.UPDATE_REQUEST]: (state, { request }) => {
		const requestIndex = state.requests.findIndex(({ id }) => id === request.id);

		if (requestIndex === -1) {
			return;
		}

		state.requests = [
			...state.requests.slice(0, requestIndex),
			userRequestsService.mapRequest(request),
			...state.requests.slice(requestIndex + 1),
		];
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
