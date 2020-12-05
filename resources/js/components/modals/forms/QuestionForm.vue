<template>
<form action="">
	<h3>Надати відповідь</h3>
	<div class="fieldset ">
		<div class="field styling-label">
			<label>Країна</label>
			<select v-model="question.country">
				<option v-for="(country, key) in countries" :key="key" :value="country.id">{{ country.name }}</option>
			</select>  
		</div>
		<div class="field styling-label">
			<label>Категорія</label>
			<select v-model="question.category">
				<option v-for="(category, key) in categories" :key="key" :value="category.id">{{ category.name }}</option>
			</select>
		</div>
	</div>
	<div class="field styling-label">
		<label>Питання</label>
		<input name="question" type="text" v-model="question.question" >
	</div>
	<div class="field styling-label">
		<label>Відповідь</label>
		<textarea name="answer" v-model="question.answer"></textarea>
	</div>
	<div class="field-checkbox">
		<label>Додавати в базу</label>
		<input type="checkbox" name="add" v-model="question.publish" >
	</div>
	<div class="actions">
		<button class="button" v-on:click.prevent="onSave">Надіслати</button>
		<button class="button secondary close" v-on:click.prevent="onCancel">Відхилити</button>
	</div>
</form>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
	props: {
		data: Object
	},
	data() {
		return {
			question: {
				id: this.data.id,
				country: this.data.country,
				category: this.data.category,
				question: this.data.question,
				answer: this.data.answer,
				publish: this.data.publish,
			},
		};
	},
	computed: {
		...mapGetters('page', [
			'countries',
			'categories',
		]),
	},
	methods: {
		onSave() {
			this.$emit('save', {
				...this.question
			});
		},
		onCancel() {
			this.$emit('cancel');
		}
	}
}
</script>
