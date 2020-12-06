<template>
	<div>
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
					<span v-if="request.responsible">{{ request.responsible.name }}</span>
					<button v-else class="button secondary" @click.stop.prevent="onAssign(request.id)" @dblclik.stop.prevent>Виконувати</button>
				</td>
				<td class="table--control">
					<a href="#" class="table__icon edit" @click.prevent="onEdit(request)">
						<svg class="table__icon-image" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.66667 13.0933H2.845L10.6067 5.47451L9.42833 4.31787L1.66667 11.9367V13.0933ZM15 14.7293H0V11.2585L11.1958 0.268795C11.3521 0.115444 11.564 0.0292969 11.785 0.0292969C12.006 0.0292969 12.2179 0.115444 12.3742 0.268795L14.7317 2.5829C14.8879 2.7363 14.9757 2.94432 14.9757 3.16122C14.9757 3.37812 14.8879 3.58615 14.7317 3.73954L5.2025 13.0933H15V14.7293ZM10.6067 3.16122L11.785 4.31787L12.9633 3.16122L11.785 2.00458L10.6067 3.16122Z" fill="#949494"/>
						</svg>
					</a>
				</td>
			</tr>
		</table>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import dateService from '../services/dateService';

export default {
	computed: {
		...mapGetters('user', [
			'user',
		]),
		...mapGetters('requests', [
			'requests',
		]),
		...mapGetters('page', [
			'statuses',
		]),
	},
	methods: {
		...mapActions('modal', [
			'showModal',
		]),
		...mapActions('requests', [
			'getRequests',
			'assignRequest'
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
			if (!request.responsible) {
				return;
			}

			if (request.responsible.id !== this.user.id) {
				return;
			}

			this.showModal({
				type: 'answerUser',
				payload: {
					...request,
				}
			});
		},

		async onAssign(requestId) {
			await this.assignRequest({
				requestId,
				userId: this.user.id,
			});
		}
	},
	async mounted() {
		await this.getRequests();
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
	width: 30px;
	padding: 5px;
}

.button {
	padding: 11px;
    height: auto;
    box-shadow: none;
}
</style>