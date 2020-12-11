<template>
<form action="" class="form">
	<h3>Надати відповідь</h3>
	<div class="fieldset ">
		<div class="field styling-label">
			<label>Країна</label>
			<select v-model="request.country" :disabled="isOperator">
				<option v-for="(country, key) in countryList" :key="key" :value="country.id">{{ country.name }}</option>
			</select>  
		</div>
		<div class="field styling-label">
			<label>Категорія</label>
			<select v-model="request.category">
				<option value=""></option>
				<option v-for="(category, key) in categories" :key="key" :value="category.id">{{ category.name }}</option>
			</select>
		</div>
		<div class="field styling-label">
			<label>Статус</label>
			<select v-model="request.status">
				<option v-for="(status, key) in statuses" :key="key" :value="status.id">{{ status.name }}</option>
			</select>
		</div>
	</div>
	<div class="field styling-label">
		<label>Питання</label>
		<input name="question" type="text" v-model="request.question" >
	</div>
	<div class="field styling-label">
		<label>Відповідь</label>
		<textarea class="textarea" name="answer" v-model="request.answer"></textarea>
	</div>
	<div class="field-checkbox">
		<label>Додавати в базу</label>
		<input type="checkbox" name="add" v-model="request.publish" >
	</div>
	<div class="actions">
		<button class="button" :disabled="disableButton" v-on:click.prevent="onSave">Надіслати</button>
		<button class="button secondary close" v-on:click.prevent="onCancel">Скасувати</button>
	</div>
</form>
</template>

<script>
import _ from 'lodash';
import { mapGetters } from 'vuex';

export default {
	props: {
		data: Object,
		disableButton: Boolean
	},
	data() {
		return {
			countryId: -1,
			request: {
				id: this.data.id,
				category: this.data.category,
				question: this.data.question,
				answer: this.data.answer,
				status: this.data.status,
				publish: false,
				country: -1,
			},
		};
	},
	computed: {
		...mapGetters('page', [
			'countries',
			'categories',
			'statuses',
		]),

		...mapGetters('user', [
			'isOperator',
		]),

		countryList() {
			if (this.countryId === -1) {
				return [
					{ id: -1, name: this.data.country },
					...this.countries,
				];
			}

			return this.countries;
		}
	},
	methods: {
		getCountryId(countryName) {
			const country = this.countries.find(country => {
				return _.toLower(country.name) === _.toLower(countryName);
			});

			if (country) {
				return country.id;
			} else {
				return -1;
			}
		},

		onSave() {
			const country = this.countryList.find(country => country.id === this.request.country) || { name: this.data.country };
			this.$emit('save', {
				...this.request,
				countryName: country.name,
			});
		},
		onCancel() {
			this.$emit('cancel');
		}
	},
	mounted() {
		const countryId = this.getCountryId(this.data.country);
		this.countryId = countryId;
		this.request.country = countryId;
	}
}
</script>

<style scoped>
.textarea {
	background: #FFFFFF;
    border: 1px solid #BABABA;
    border-radius: 4px;
    padding: 16px;
	font-size: 18px;
	width: 100%;
	resize: none;
	height: 200px;
}
.form {
	min-width: 800px;
}
</style>
