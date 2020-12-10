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
		...mapActions('alerts', [
			'success',
		]),
		async onDelete() {
			try {
				this.sending = true;
				const workerId = this.data.id;
				await this.deleteWorker(workerId);
				this.success({ message: 'Користуача видалено' });
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
