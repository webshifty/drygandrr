<template>
	<div class="page">
		<div class="breadcrumbs">
			<span class="breadcrumbs__link"><router-link to="/">Працівники</router-link></span> - <span>Працівник</span>			
		</div>
		<div class="user-info">
			<div class="user-info__name">{{ worker.name }}</div>
			<div class="user-info__country">
				{{ worker.countryName }}
			</div>
		</div>
		<div class="worker-table">
			<div class="toolbar__top">
				<div class="tables_tabs">
					<a href="#" :class="{ active: isActive('requests') }" @click.prevent="tab = 'requests'">Запити у виконанні</a>
					<a href="#" :class="{ active: isActive('info') }" @click.prevent="tab = 'info'">Інформація</a>
				</div>
			</div>
			<RequestTable
				v-if="isActive('requests')"
				:meta="meta"
				:requests="requests"
				:editable="false"
				@next="nextPage"
				@prev="prevPage"
			/>
			<div v-if="isActive('info')" class="profile-container">
				<WorkerProfile
					:worker="worker"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import RequestTable from '../../components/tables/RequestTable.vue';
import SettingsForm from '../../components/SettingsForm.vue';
import WorkerProfile from '../../components/main/WorkerProfile.vue';

export default {
	components: {
		RequestTable,
		SettingsForm,
		WorkerProfile,
	},
	data: () => ({
		tab: 'requests',
	}),
	computed: {
		...mapGetters('workers', [
			'workers',
			'worker',
			'requestsByWorkerId',
			'metaByWorkerId',
		]),
		requests() {
			return this.requestsByWorkerId[this.$route.params.id] || [];
		},
		meta() {
			return this.metaByWorkerId[this.$route.params.id] || { total: 0, per_page: 20, page: 1, last_page: 1 };
		}
	},
	methods: {
		...mapActions('workers', [
			'getRequests',
			'getWorker',
			'nextPageByWorker',
			'prevPageByWorker',
		]),
		isActive(tab) {
			return this.tab === tab;
		},
		nextPage() {
			this.nextPageByWorker(this.$route.params.id);
		},
		prevPage() {
			this.prevPageByWorker(this.$route.params.id);
		}
	},
	async mounted() {
		const workerId = this.$route.params.id;
		await this.getWorker(workerId);
		await this.getRequests(workerId);
	}
}
</script>

<style scoped>
.tabs {
	background-color: #fff;
}

.worker-table {
	height: calc(100% - 125px);
}

.toolbar__top {
    display: flex;
    background: #fff;
    padding: 19px 23px;
    align-items: center;
    justify-content: space-between;
}

.tables_tabs {
    display: flex;
}

.tables_tabs a {
    font-size: 14px;
    line-height: 17px;
    color: #595959;
    padding: 8px 4px;
    display: block;
    min-width: 156px;
    text-align: center;
}

.tables_tabs a.active {
    color: #004BC1;
    border-bottom: 2px solid;
}

.status {
    display: flex;
    font-size: 14px;
    line-height: 17px;
    width: 200px;
}

.status select {
    border: 0;
    padding: 0;
    height: auto;
    font-size: 14px;
    line-height: 17px;
    color: #004BC1;
}

.breadcrumbs {
	color: #575757;
	font-weight: bolder;
	font-size: 14px;
}

.breadcrumbs__link {
	color: #004BC1;
}
.breadcrumbs__link a {
	font-size: 14px;
}

.user-info {
	margin-top: 28px;
	margin-bottom: 15px;
}

.user-info__name {
	color: #252525;
	font-weight: bold;
	font-size: 21px;
}
.user-info__country {
	color: #595959;
	font-size: 14px;
	font-weight: normal;
	margin-top: 10px;
}

</style>
