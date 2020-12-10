<template>
	<div v-if="isShown" class="alert">
		<ErrorAlert
			v-if="alert.type === 'error'"
			:message="alert.message"
			v-on:close="hideAlert"
		/>
		<SuccessAlert
			v-if="alert.type === 'success'"
			:message="alert.message"
			v-on:close="hideAlert"
		/>
	</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ErrorAlert from './ErrorAlert.vue';
import SuccessAlert from './SuccessAlert.vue';

export default {
	components: {
		ErrorAlert,
		SuccessAlert,
	},
	computed: {
		...mapGetters('alerts', [
			'isShown',
			'alert',
		])
	},
	methods: {
		...mapActions('alerts', [
			'hideAlert'
		]),
	},
	mounted() {
		setTimeout(() => {
			this.hideAlert();
		}, 5000);
	}
}
</script>
<style scoped>
.alert {
	min-width: 300px;
	min-height: 50px;
	position: fixed;
	bottom: 10px;
	right: 30px;
}
</style>