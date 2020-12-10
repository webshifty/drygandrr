<template>
	<div class="page">
		<div class="action-block">
			<div class="action-block__left">
				<div v-if="isAdmin" class="dropdown">
					<label for="filter-requests">Країни:</label>
					<select id="filter-requests" :value="filter.country" @change="onFilterCountries">
						<option value="">Усі</option>
						<option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
					</select>
				</div>
				<div v-if="isOperator" class="dropdown">
					<label for="filter-requests">Запити:</label>
					<select id="filter-requests" :value="filter.requests" @change="onFilterRequests">
						<option value="my">Мої</option>
						<option value="">Усі</option>
					</select>
				</div>
				<div class="dropdown dropdown--left">
					<label for="filter-category">Категорія:</label>
					<select id="filter-category" :value="filter.category" @change="onFilterCategory">
						<option value="0">Усі</option>
						<option :value="-1">Без категорії</option>
						<option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
					</select>
				</div>
			</div>
		</div>
		<RequestTable
			:requests="requests"
			:meta="meta"
			:editable="true"
			@edit="onEdit"
			@next="nextPage"
			@prev="prevPage"
		/>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Dropdown from './controls/Dropdown.vue';
import RequestTable from './tables/RequestTable';
import dateService from '../services/dateService';

export default {
	components: {
		Dropdown,
		RequestTable,
	},
	computed: {
		...mapGetters('user', [
			'user',
			'isOperator',
			'isAdmin',
		]),
		...mapGetters('requests', [
			'requests',
			'filter',
			'meta',
		]),
		...mapGetters('page', [
			'categories',
			'countries',
		]),
	},
	methods: {
		...mapActions('modal', [
			'showModal',
		]),
		...mapActions('requests', [
			'getRequests',
			'changeFilter',
			'nextPage',
			'prevPage',
		]),
		onEdit(request) {
			if (!this.isAdmin) {
				if (!request.responsible) {
					return;
				}
	
				if (request.responsible.id !== this.user.id) {
					return;
				}
			}

			this.showModal({
				type: 'answerUser',
				payload: {
					...request,
				}
			});
		},

		async onFilterRequests(e) {
			await this.changeFilter({
				filter: 'requests',
				value: e.target.value,
			});
		},

		async onFilterCategory(e) {
			await this.changeFilter({
				filter: 'category',
				value: Number(e.target.value || 0),
			});
		},

		async onFilterCountries(e) {
			await this.changeFilter({
				filter: 'country',
				value: Number(e.target.value || 0),
			});
		},
	},
	async mounted() {
		await this.getRequests();
	}
};
</script>
<style scoped>

</style>