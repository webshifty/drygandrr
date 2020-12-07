<template>
<form action="" class="form">
	<h3>Зміна інформації</h3>
	<div>
		<div class="field styling-label">
			<label>Ім'я</label>
			<input type="text" v-model="user.name" >
			<div class="text-danger">{{ errors.name }}</div>
		</div>
		<div class="field styling-label">
			<label>Email</label>
			<input type="text" v-model="user.email" >
			<div class="text-danger">{{ errors.email }}</div>
		</div>
	</div>
	<div>
		<div class="field styling-label">
			<label>Країна</label>
			<select v-model="user.work_country">
				<option v-for="(country, key) in countries" :key="key" :value="country.id">{{ country.name }}</option>
			</select>  
			<div class="text-danger">{{ errors.work_country }}</div>
		</div>
	</div>
	<div class="fieldset">
		<div class="field styling-label">
			<label>Старий пароль</label>
			<input type="password" v-model="user.current_password" >
			<div class="text-danger">{{ errors.current_password }}</div>
		</div>
		<div class="field styling-label">
			<label>Новий пароль</label>
			<input type="password" v-model="user.password" >
			<div class="text-danger">{{ errors.password }}</div>
		</div>
		<div class="field styling-label">
			<label>Повторіть пароль</label>
			<input type="password" v-model="user.password_confirmation" >
		</div>
	</div>
	<div class="text-danger">&nbsp;{{ error }}</div>

	<div class="actions">
		<button class="button" :disabled="sending" v-on:click.prevent="onSave(user)">Зберегти</button>
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
			user: {
				id: this.data.id,
				name: this.data.name,
				email: this.data.email,
				work_country: this.data.work_country,
				current_password: '',
				password: '',
				password_confirmation: '',
			},
			errors: {
				name: '',
				email: '',
				work_country: '',
				password: '',
				current_password: '',
			},
			sending: false,
		};
	},
	computed: {
		...mapGetters('page', [
			'countries',
		]),

		error() {
			if (this.user.password && this.user.password.length < 8) {
				return 'Мінімальна довжина пароля 8 символів';
			}

			if (this.user.password !== this.user.password_confirmation) {
				return 'Паролі не співпадають';
			}

			return '';
		}
	},
	methods: {
		...mapActions('user', [
			'updateUser'
		]),

		async onSave(data) {
			try {
				this.sending = true;
				await this.updateUser(data);
				this.sending = false;
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
				work_country: (errors.work_country || [''])[0],
				password: (errors.password || [''])[0],
				current_password: (errors.current_password || [''])[0],
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