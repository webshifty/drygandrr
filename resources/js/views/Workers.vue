<template>
	<Dashboard @search="onSearch">
		<template v-if="isAdmin">
			<WorkersTable />
		</template>
		<template v-else>
			У вас немає доступу до цієї сторінки
		</template>
	</Dashboard>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Dashboard from '../components/layouts/Dashboard';
import WorkersTable from '../components/WorkersTable.vue';

export default {
	components: {
		Dashboard,
		WorkersTable,
	},
	computed: {
		...mapGetters('user', [
			'isAdmin',
		]),
	},
	methods: {
		...mapActions('workers', [
			'changeFilter',
		]),
		async onSearch(search) {
			await this.changeFilter({ filter: 'search', value: search });
		}
	}
}
</script>
