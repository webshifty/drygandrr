<template>
	<Dashboard @search="onSearch">
		<template v-if="isAdmin">
			<router-view></router-view>
		</template>
		<template v-else>
			У вас немає доступу до цієї сторінки
		</template>
	</Dashboard>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Dashboard from '../components/layouts/Dashboard.vue';

export default {
	components: {
		Dashboard,
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
