<template>
	<div>
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
		<table class="table">
			<tr>
				<th>Запитання</th>
				<th class="table-header">Користувач</th>
				<th class="table-header">Статус</th>
				<th class="table-header--date">Дата</th>
				<th class="table-header">Виконує</th>
				<th class="table__header table__header--control table--control"></th>
			</tr>
			<tr v-for="request in requests" :key="request.id" class="table__row" @dblclick="onEdit(request)">
				<td>{{ request.question }}</td>
				<td>{{ request.user }}</td>
				<td class="table-status"><span class="status" :class="{
					'status--new': request.status === 0,
					'status--executing': request.status === 1,
					'status--completed': request.status === 2,
				}"></span>{{ getStatus(request.status) }}</td>
				<td>{{ renderDate(request.created_at) }}</td>
				<td>
					<div v-if="isAdmin">
						<Dropdown
							emptyValue="Немає"
							:value="getResponsible(request)"
							:options="getWorkersByCountry(request.country)"
							@change="changeResponsible(request.id, $event)"
						/>
					</div>
					<div v-else-if="request.responsible" class="responsible">{{ request.responsible.name }}</div>
					<button v-else class="button secondary" @click.stop.prevent="onAssign(request.id)" @dblclik.stop.prevent>Виконувати</button>
				</td>
				<td class="table--control">
					<a href="#" class="table__icon edit" @click.prevent="onEdit(request)">
						<svg class="table__icon-image" width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.66667 13.0933H2.845L10.6067 5.47451L9.42833 4.31787L1.66667 11.9367V13.0933ZM15 14.7293H0V11.2585L11.1958 0.268795C11.3521 0.115444 11.564 0.0292969 11.785 0.0292969C12.006 0.0292969 12.2179 0.115444 12.3742 0.268795L14.7317 2.5829C14.8879 2.7363 14.9757 2.94432 14.9757 3.16122C14.9757 3.37812 14.8879 3.58615 14.7317 3.73954L5.2025 13.0933H15V14.7293ZM10.6067 3.16122L11.785 4.31787L12.9633 3.16122L11.785 2.00458L10.6067 3.16122Z"/>
						</svg>
					</a>
				</td>
			</tr>
		</table>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Dropdown from './controls/Dropdown.vue';
import dateService from '../services/dateService';

export default {
	components: {
		Dropdown,
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
		]),
		...mapGetters('page', [
			'statuses',
			'categories',
			'countries',
		]),
		...mapGetters('workers', [
			'workers',
			'workersByCountry',
		]),
	},
	methods: {
		...mapActions('modal', [
			'showModal',
		]),
		...mapActions('workers', [
			'getWorkers',
		]),
		...mapActions('requests', [
			'getRequests',
			'assignRequest',
			'changeFilter',
		]),
		renderDate(strDate) {
			return dateService.getFormatDate(strDate);
		},
		getStatus(statusId) {
			const status = this.statuses.find(status => status.id === statusId);

			if (!status) {
				return '';
			}

			return status.name;
		},
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

		getResponsible(request) {
			if (!request.responsible) {
				return '';
			}

			return request.responsible.id;
		},

		async onAssign(requestId) {
			await this.assignRequest({
				requestId,
				userId: this.user.id,
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

		async changeResponsible(requestId, userId) {
			await this.assignRequest({
				requestId,
				userId: userId,
			});
		},

		getCountryId(countryName = '') {
			const country = this.countries.find(country => {
				return (
					(country.name || '').toLowerCase() === countryName.toLowerCase()
					||
					(country.name_ru || '').toLowerCase() === countryName.toLowerCase()
					||
					(country.name_en || '').toLowerCase() === countryName.toLowerCase()
				);
			});

			if (!country) {
				return;
			}

			return country.id;
		},

		getWorkersByCountry(country) {
			return this.workersByCountry[
				this.getCountryId(country)
			] || [];
		}
	},
	async mounted() {
		await this.getRequests();
		await this.getWorkers();
	}
};
</script>
<style scoped>
.table-header {
	width: 150px;
}
.table-header--date {
	width: 200px;
}

.status {
	display: inline-block;
	width: 8px;
	height: 8px;
	border-radius: 50%;
    margin: 1px 8px;
}

.status--new {
	background-color: #EB5757;
}

.status--executing {
	background-color: #219653;
}

.status--completed {
	background-color: #004BC1;
}

.table-status {
	white-space: nowrap;
}

.table--control {
	width: 70px;
	padding: 5px 15px;
	text-align: right;
}

.responsible,
.button {
	padding: 10px 22px;
    height: auto;
	box-shadow: none;
	font-size: 14px;
}
</style>