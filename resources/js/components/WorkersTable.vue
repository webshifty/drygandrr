<template>
	<div class="page">
		<div class="action-block">
			<div class="action-block__left">
				<div class="dropdown">
					<label for="filter-category"><b>{{ countWorkers }}</b> працівник{{ ending }}</label>
				</div>
				<div class="dropdown">
					<label for="filter-country">Країна:</label>
					<select id="filter-country" :value="filter.country" @change="onFilterCountry">
						<option value="">Усі</option>
						<option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
					</select>
				</div>
			</div>
		</div>
		<div class="questions-block table-container">
			<table class="table">
				<tr>
					<th class="table__header table__header--questions">Працівник</th>
					<th>Країна</th>
					<th>Пошта</th>
					<th>Запити у виконанні</th>
					<th class="table__header table__header--control"></th>
				</tr>
				<tr
					class="table__row"
					v-for="worker in workers"
					:key="worker.id"
				>
					<td :class="{ 'font-weight-bold': worker.is_admin, 'font-weight-italic': (!worker.is_admin && !worker.is_operator) }" :title="getRole(worker)">{{ worker.name }}</td>
					<td>{{ worker.countryName }}</td>
					<td>{{ worker.email }}</td>
					<td>{{ worker.requests_count }}</td>
					<td>
						<a href="#" class="table__icon edit">
							<router-link :to="String(worker.id)">
								<svg class="table__icon-image" width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
									<path d="M10.6505 6.10003L5.957 1.27256L7.19425 -3.14471e-07L14 7L7.19425 14L5.957 12.7274L10.6505 7.89997L-2.66641e-07 7.89997L-3.45319e-07 6.10003L10.6505 6.10003Z"/>
								</svg>
							</router-link>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<Pagination
			:total="meta.total"
			:page="meta.page"
			:perPage="meta.per_page"
			:lastPage="meta.last_page"
			@next="nextPage"
			@prev="prevPage"
		/>
	</div>
</template>

<script>
import Pagination from './tables/Pagination.vue';
import { mapActions, mapGetters } from 'vuex';

export default {
	components: {
		Pagination,
	},
	computed: {
		...mapGetters('workers', [
			'countWorkers',
			'workers',
			'filter',
			'meta',
		]),
		...mapGetters('page', [
			'countries',
		]),
		ending() {
			const str = this.countWorkers + '';

			if (/1$/.test(str) && !/11$/.test(str)) {
				return '';
			}

			if (/[234]$/.test(str) && !/1[234]$/.test(str)) {
				return 'а';
			}

			return 'ів';
		},
	},

	methods: {
		...mapActions('workers', [
			'getWorkers',
			'changeFilter',
			'nextPage',
			'prevPage',
		]),

		getRole(worker) {
			if (worker.is_admin) {
				return 'Адміністратор';
			} else if (worker.is_operator) {
				return 'Оператор';
			} else {
				return 'Без ролі';
			}
		},

		async onFilterCountry(e) {
			await this.changeFilter({
				filter: 'country',
				value: e.target.value,
			});
		},
	},
	async mounted() {
		await this.getWorkers();
	}
};
</script>

<style scoped>
.table__header--control {
	width: 50px;
}
b {
	font-weight: bolder;
}
</style>
