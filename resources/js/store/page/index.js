export default {
	namespaced: true,
	state: () => window.__PAGE_STATE__,
	getters: {
		routeName: state => state.routeName,
		routes: state => state.routes,
	}
};