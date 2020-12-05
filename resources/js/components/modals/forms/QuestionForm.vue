<template>
<form action="">
	<h3>Надати відповідь</h3>
	<div class="fieldset ">
		<div class="field styling-label">
			<label>Країна</label>
			<input name="country" type="text" v-model="question.country" >
		</div>
		<div class="field styling-label">
			<label>Категорія</label>
			<select v-model="question.category">
				<option v-for="(category, key) in categories" :key="key">{{ category }}</option>
			</select>
		</div>
		<div class="field styling-label">
			<label>Статус</label>
			<select v-model="question.status">
				<option v-for="(status, key) in statuses" :key="key">{{ status }}</option>
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
		<input type="checkbox" name="add" v-model="toDb" >
	</div>
	<div class="actions">
		<button class="button" v-on:click.prevent="onSave">Надіслати</button>
		<button class="button secondary close" v-on:click.prevent="onCancel">Відхилити</button>
	</div>
</form>
</template>

<script>
export default {
	props: {
		data: Object
	},
	data() {
		return {
			question: {
				country: this.data.country,
				category: this.data.category,
				status: this.data.status,
				question: this.data.question,
				answer: this.data.answer,
			},
			categories: [
				"Австрія",
				"Китай",
			],
			statuses: [
				"Виконується",
				"Новий"
			],
			toDb: false,
		};
	},
	methods: {
		onSave() {
			this.$emit('save', {
				...this.question,
				toDb: this.toDb,
			});
		},
		onCancel() {
			this.$emit('cancel');
		}
	}
}
</script>
