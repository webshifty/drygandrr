<template>
	<div class="page">
		<div class="table-container">
			<table class="table">
				<thead>
					<tr>
						<th>Запитання</th>
						<th class="table-header">Користувач</th>
						<th class="table-header">Статус</th>
						<th class="table-header--date">Дата</th>
						<th class="table-header">Виконує</th>
						<th v-if="editable" class="table__header table__header--control table--control"></th>
					</tr>
				</thead>
				<tbody class="table-rows">
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
									:options="getWorkersByCountry(request)"
									@change="changeResponsible(request.id, $event)"
								/>
							</div>
							<div v-else-if="request.responsible" class="responsible">{{ request.responsible.name }}</div>
							<button v-else class="button secondary" @click.stop.prevent="onAssign(request.id)" @dblclik.stop.prevent>Виконувати</button>
						</td>
						<td v-if="editable" class="table--control">
							<a href="#" class="table__icon edit" @click.prevent="onEdit(request)">
								<svg class="table__icon-image" width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.66667 13.0933H2.845L10.6067 5.47451L9.42833 4.31787L1.66667 11.9367V13.0933ZM15 14.7293H0V11.2585L11.1958 0.268795C11.3521 0.115444 11.564 0.0292969 11.785 0.0292969C12.006 0.0292969 12.2179 0.115444 12.3742 0.268795L14.7317 2.5829C14.8879 2.7363 14.9757 2.94432 14.9757 3.16122C14.9757 3.37812 14.8879 3.58615 14.7317 3.73954L5.2025 13.0933H15V14.7293ZM10.6067 3.16122L11.785 4.31787L12.9633 3.16122L11.785 2.00458L10.6067 3.16122Z"/>
								</svg>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<Pagination />
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import dateService from '../../services/dateService';
import Dropdown from '../controls/Dropdown.vue'
import Pagination from './Pagination.vue';

export default {
	props: {
		requests: Array,
		editable: Boolean,
	},
	components: {
		Dropdown,
		Pagination,
	},
	computed: {
		...mapGetters('user', [
			'user',
			'isAdmin',
		]),
		...mapGetters('page', [
			'statuses',
			'countries',
		]),
		...mapGetters('workers', [
			'workersByCountry',
		]),
	},
	methods: {
		...mapActions('workers', [
			'getWorkerList',
		]),
		...mapActions('requests', [
			'assignRequest',
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
			if (!this.editable) {
				return;
			}

			this.$emit('edit', request);
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

		getWorkersByCountry(request) {
			const workers = this.workersByCountry[
				this.getCountryId(request.country)
			] || [];

			if (!request.responsible) {
				return workers;
			}
			const responsible = request.responsible;

			if (workers.some(worker => worker.id === responsible.id)) {
				return workers;
			}

			return workers.concat(responsible);
		}
	},
	async mounted() {
		await this.getWorkerList();
	}
}
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

.table-rows {
	overflow: auto;
}

</style>
