<template>
	<DeleteForm
		:entityName="'питання'"
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
		...mapActions('questions', [
			'deleteQuestion'
		]),
		async onDelete() {
			try {
				this.sending = true;
				const questionId = this.data.questionId;
				await this.deleteQuestion(questionId);
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
