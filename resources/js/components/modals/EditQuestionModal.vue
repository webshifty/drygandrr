<template>
<QuestionForm
	:data="data"
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
	methods: {
		...mapActions('questions', [
			'updateQuestion'
		]),

		async onSave(data) {
			await this.updateQuestion(data);
			this.$emit('close');
		},

		onClose() {
			this.$emit('close');
		}
	}
}
</script>
