<template>
<form action="" class="form">
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
		<textarea class="textarea" name="answer" v-model="question.answer"></textarea>
	</div>
	<div class="actions">
		<button class="button" :disabled="disableButton" v-on:click.prevent="onSave">Надіслати</button>
		<button class="button secondary close" v-on:click.prevent="onCancel">Відхилити</button>
	</div>
</form>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
	props: {
		data: Object,
		disableButton: Boolean
	},
	data() {
		return {
			question: {
				id: this.data.id,
				country: this.data.country,
				category: this.data.category,
				question: this.data.question,
				answer: this.data.answer,
				publish: true,
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
