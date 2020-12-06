<template>
	<div>
		<table class="table">
			<tr>
				<th>Запитання</th>
				<th class="table-header">Користувач</th>
				<th class="table-header">Статус</th>
				<th class="table-header--date">Дата</th>
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
			</tr>
		</table>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import dateService from '../services/dateService';

export default {
	computed: {
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
			this.showModal({
				type: 'answerUser',
				payload: {
					...request,
				}
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
</style>