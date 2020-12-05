<template>
<QuestionForm
	:data="data"
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
	methods: {
		...mapActions('questions', [
			'createQuestion'
		]),

		async onSave(data) {
			await this.createQuestion(data);
			this.$emit('close');
		},

		onClose() {
			this.$emit('close');
		}
	}
}
</script>
