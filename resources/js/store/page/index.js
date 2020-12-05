export default {
	namespaced: true,
	state: () => ({
		routes: window.__PAGE_STATE__?.routes || {},
		routeName: window.__PAGE_STATE__?.routeName || '',
		countries: window.__PAGE_STATE__?.countries || [],
		categories: window.__PAGE_STATE__?.categories || [],
	}),
	getters: {
		routeName: state => state.routeName,
		routes: state => state.routes,
		countries: state => state.countries,
		categories: state => state.categories,
	}
};