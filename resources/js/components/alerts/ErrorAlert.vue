<template>
	<div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
		<span class="text-xl inline-block mr-5 align-middle">
			<i class="fas fa-bell" />
		</span>
		<span class="inline-block align-middle mr-8">
			{{ message }}
		</span>
		<button v-on:click.prevent="onClose" class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
			<span>×</span>
		</button>
	</div>
</template>

<script>
export default {
	props: {
		message: String,
	},

	methods: {
		onClose() {
			this.$emit('close');
		}
	}
}
</script>

<style scoped>

.error {
	padding: 5px 15px;
	border: 1px solid tomato;
	border-radius: 2px;
	background-color: #fff3f1;
	font-size: 12px;
}

.error__message {
	color: tomato;
}

</style>