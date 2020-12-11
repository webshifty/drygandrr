<template>
<form action="" class="form">
	<h3>Додати Категорію</h3>
	<div class="field styling-label">
		<label>Назва категоріїї</label>
		<input name="category" type="text" v-model="category" >
	</div>
	<div class="actions">
		<button class="button" :disabled="sending" v-on:click.prevent="onSave">Додати</button>
		<button class="button secondary close" v-on:click.prevent="onCancel">Скасувати</button>
	</div>
</form>
</template>

<script>
import { mapActions } from 'vuex';

export default {
	props: {
		data: Object,
	},
	data() {
		return {
			category: '',
			sending: false,
		};
	},
	methods: {
		...mapActions('page', [
			'addCategory'
		]),

		async onSave() {
			try {
				this.sending = true;
				await this.addCategory(this.category);
			} catch (error) {
				throw error;
			} finally {
				this.sending = false;
				this.$emit('close');
			}
		},

		onCancel() {
			this.$emit('close');
		}
	}
}
</script>
