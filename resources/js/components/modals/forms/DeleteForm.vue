<template>
<form action="">
	<h3>Ви впевнені, що хочете видалити {{ entityName }}?</h3>
	<div class="actions">
		<button class="button" :disabled="disableButton" @click.prevent="onDelete">Так</button>
		<button class="button secondary close" @click.prevent="onCancel">Відхилити</button>
	</div>
</form>
</template>

<script>
export default {
	props: {
		entityName: String,
		disableButton: Boolean,
	},
	methods: {
		onDelete() {
			this.$emit('delete');
		},
		onCancel() {
			this.$emit('cancel');
		}
	}
}
</script>
