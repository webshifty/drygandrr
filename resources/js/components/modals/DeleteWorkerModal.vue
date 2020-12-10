<template>
	<DeleteForm
		:entityName="'працівника'"
		:disableButton="sending"
		@delete="onDelete"
		@cancel="onClose"
	/>
</template>
<script>
import { mapActions } from 'vuex';
import DeleteForm from './forms/DeleteForm.vue'

export default {
	props: {
		data: Object,
	},
	components: {
		DeleteForm,
	},
	data() {
		return {
			sending: false,
		};
	},
	methods: {
		...mapActions('workers', [
			'deleteWorker'
		]),
		async onDelete() {
			try {
				this.sending = true;
				const workerId = this.data.id;
				await this.deleteWorker(workerId);
				this.$router.push('/');
			} catch (error) {
				throw error;
			} finally {
				this.sending = false;
				this.$emit('close');
			}
		},

		onClose() {
			this.$emit('close');
		}
	}
}
</script>
