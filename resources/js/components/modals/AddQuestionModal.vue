<template>
<QuestionForm
	:data="data"
	:disableButton="sending"
	v-on:save="onSave"
	v-on:cancel="onClose"
/>
</template>

<script>
import { mapActions } from 'vuex';
import QuestionForm from './forms/QuestionForm.vue'

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
			'createQuestion'
		]),

		async onSave(data) {
			try {
				this.sending = true;
				await this.createQuestion(data);
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
