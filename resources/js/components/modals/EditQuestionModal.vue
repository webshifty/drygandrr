<template>
<QuestionForm
	:title="'Редагувати запитання'"
	:data="data"
	:disableButton="sending"
	:editCategory="isAdmin"
	v-on:save="onSave"
	v-on:cancel="onClose"
/>
</template>

<script>
import QuestionForm from './forms/QuestionForm.vue'
import { mapActions, mapGetters } from 'vuex';

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
	computed: {
		...mapGetters('user', [
			'isAdmin',
		]),
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
