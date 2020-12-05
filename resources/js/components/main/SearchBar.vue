<template>
	<div>
		<div class="search">
			<input name="search" type="text" placeholder="Пошук" @keydown="onSearch">
		</div>
		<span class="notification"></span>
	</div>	
</template>

<script>
import _ from 'lodash';

export default {
	methods: {
		onSearch: _.debounce(function (e) {
			this.$emit('search', e.target.value);
		}, 300)
	},
}
</script>

<style scoped>
.search input {
    border: none;
    border-radius: 0;
	border-bottom: 1px solid #eaeaea;
	height: 60px;
}
</style>
