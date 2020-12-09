<template>
	<select class="dropdown" @change="onChange">
		<option value="" :selected="isSelected('')">{{ emptyValue }}</option>
		<option
			v-for="option in options"
			:key="option.id"
			:value="option.id"
			:selected="isSelected(option.id)"
		>{{ option.name }}</option>
	</select>
</template>

<script>
export default {
	props: {
		emptyValue: String,
		options: Array,
		value: [Number, String]
	},
	methods: {
		isSelected(id) {
			return String(this.value) === String(id);
		},
		onChange(e) {
			this.$emit('change', e.target.value);
		}
	}
}
</script>
<style scoped>
.dropdown {
	width: 200px;
	max-width: none;
	padding: 5px 10px;
	border-radius: 2px;
	height: auto;
}
</style>