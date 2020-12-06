<template>
<QuestionForm
	:title="'Редагувати запитання'"
	:data="data"
	:disableButton="sending"
	v-on:save="onSave"
	v-on:cancel="onClose"
/>
</template>

<script>
import QuestionForm from './forms/QuestionForm.vue'
import { mapActions } from 'vuex';

export default {
	components: {
		QuestionForm,
	},
	props: {
		data: Object,
	},
	data() {
		return {
			sending: false,
		};
	},
	methods: {
		...mapActions('questions', [
			'updateQuestion'
		]),

		async onSave(data) {
			try {
				this.sending = true;
				await this.updateQuestion(data);
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
