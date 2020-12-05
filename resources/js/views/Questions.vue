<template>
	<Dashboard @search="onSearch">
		<QuestionsTable />
	</Dashboard>
</template>

<script>
import { mapActions } from 'vuex';
import Dashboard from '../components/layouts/Dashboard';
import QuestionsTable from '../components/QuestionsTable';

export default {
	components: {
		Dashboard,
		QuestionsTable,
	},
	methods: {
		...mapActions('questions', [
			'changeFilter'
		]),

		async onSearch(search) {
			await this.changeFilter({
				filter: 'search',
				value: search,
			});
		}
	}
}
</script>
