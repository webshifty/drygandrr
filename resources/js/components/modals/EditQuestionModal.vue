<template>
<QuestionForm
	:data="data"
	v-on:save="onSave"
	v-on:cancel="onClose"
/>
</template>

<script>
import QuestionForm from './forms/QuestionForm.vue'

export default {
	components: {
		QuestionForm,
	},
	props: {
		data: Object,
	},
	methods: {
		onSave(data) {
			console.log(data);
			this.$emit('close');
		},

		onClose() {
			this.$emit('close');
		}
	}
}
</script>
