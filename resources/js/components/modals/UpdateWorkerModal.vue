<template>
<form action="" class="form">
	<h3>Зміна інформації</h3>
	<div>
		<div class="field styling-label">
			<label>Ім'я</label>
			<input type="text" v-model="worker.name" >
			<div class="text-danger">{{ errors.name }}</div>
		</div>
		<div class="field styling-label">
			<label>Email</label>
			<input type="text" v-model="worker.email" >
			<div class="text-danger">{{ errors.email }}</div>
		</div>
	</div>
	<div>
		<div class="field styling-label">
			<label>Країна</label>
			<select v-model="worker.country">
				<option v-for="(country, key) in countries" :key="key" :value="country.id">{{ country.name }}</option>
			</select>  
			<div class="text-danger">{{ errors.country }}</div>
		</div>
		<div class="field styling-label">
			<label>Роль</label>
			<select v-model="worker.access">
				<option value=""></option>
				<option :value="4">Оператор</option>
				<option :value="7">Адміністратор</option>
			</select>  
			<div class="text-danger">{{ errors.access }}</div>
		</div>
	</div>

	<div class="actions">
		<button class="button" :disabled="sending" v-on:click.prevent="onSave(worker)">Зберегти</button>
		<button class="button secondary close" v-on:click.prevent="onClose">Відхилити</button>
	</div>
</form>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
	props: {
		data: Object,
	},
	data() {
		return {
			worker: {
				id: this.data.id,
				name: this.data.name,
				email: this.data.email,
				country: this.data.country,
				access: this.data.access,
			},
			errors: {
				name: '',
				email: '',
				country: '',
				access: '',
			},
			sending: false,
		};
	},
	computed: {
		...mapGetters('page', [
			'countries',
		]),
	},
	methods: {
		...mapActions('workers', [
			'updateWorker'
		]),
		...mapActions('alerts', [
			'success',
		]),

		async onSave(data) {
			try {
				this.sending = true;
				await this.updateWorker(data);
				this.sending = false;
				this.success({ message: 'Працівника оновлено' });
				this.$emit('close');
			} catch (error) {
				this.sending = false;
				if (error.response && error.response.status === 422) {
					return this.renderErrors(error.response.data.errors);
				}
				this.$emit('close');
				throw error;
			}
		},

		renderErrors(errors) {
			this.errors = {
				name: (errors.name || [''])[0],
				email: (errors.email || [''])[0],
				country: (errors.country || [''])[0],
				accesss: (errors.accesss || [''])[0],
			};
		},

		onClose() {
			this.$emit('close');
		}
	}
}
</script>
<style scoped>
.text-danger {
	font-size: .9em;
}
</style>