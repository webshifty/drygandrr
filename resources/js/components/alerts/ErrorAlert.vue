<template>
	<div class="alert alert-danger">
		<span class="text-xl inline-block mr-5 align-middle">
			<i class="fas fa-bell" />
		</span>
		<span class="inline-block align-middle mr-8">
			{{ message }}
		</span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" v-on:click.prevent="onClose">
			<span aria-hidden="true">&times;</span>
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