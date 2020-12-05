import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
axios.interceptors.response.use(
	response => response,
	error => {
		if (error.response) {
			return Promise.reject(
				new Error(error?.response?.data.message || error.message)
			);
		} else {
			return Promise.reject(error);
		}
	},
);
export default {
	get(url, params) {
		return axios.get(url, {
			params,
		});
	},

	post(url, data) {
		return axios.post(url, data);
	},

	put(url, data) {
		return axios.put(url, data);
	},

	delete(url) {
		return axios.delete(url);
	}
};
