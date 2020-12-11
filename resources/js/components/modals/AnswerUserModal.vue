<template>
<AnswerForm
	:data="data"
	:disableButton="sending"
	v-on:save="onSave"
	v-on:send="onSend"
	v-on:cancel="onClose"
/>
</template>

<script>
import { mapActions } from 'vuex';
import AnswerForm from './forms/AnswerForm.vue'

export default {
	components: {
		AnswerForm,
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
		...mapActions('requests', [
			'updateRequest',
			'sendMessage',
		]),

		async onSave(data) {
			try {
				this.sending = true;
				await this.updateRequest(data);
			} catch (error) {
				throw error;
			} finally {
				this.sending = false;
			}
		},

		async onSend(data) {
			try {
				this.sending = true;
				await this.sendMessage(data);
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
