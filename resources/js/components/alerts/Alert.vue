<template>
	<div>
		<ErrorAlert
			v-if="alert.type === 'error'"
			:message="alert.message"
			v-on:close="hideAlert"
		/>
	</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ErrorAlert from './ErrorAlert.vue'

export default {
	components: {
		ErrorAlert,
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
	}
}
</script>
