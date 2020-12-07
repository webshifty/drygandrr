import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
axios.interceptors.response.use(
	response => response,
	error => {
		if (!error.response) {
			return Promise.reject(error);
		}
		const err = new Error(error?.response?.data.message || error.message);
		err.response = error.response;
		return Promise.reject(err);
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
	},

	file(url, file) {
		const formData = new FormData();
		formData.append('image', file);

		return axios.post(url, formData, {
			headers: {
			  'Content-Type': 'multipart/form-data'
			}
		});
	}
};
