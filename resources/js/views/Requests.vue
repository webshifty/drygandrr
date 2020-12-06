<template>
	<Dashboard @search="onSearch">
		<RequestsTable />
	</Dashboard>
</template>

<script>
import { mapActions } from 'vuex';
import Dashboard from '../components/layouts/Dashboard';
import RequestsTable from '../components/RequestsTable';

export default {
	components: {
		Dashboard,
		RequestsTable,
	},
	methods: {
		...mapActions('requests', [
			'changeFilter'
		]),

		async onSearch(search) {
			await this.changeFilter({
				filter: 'search',
				value: search,
			});
		},
	},
}
</script>
