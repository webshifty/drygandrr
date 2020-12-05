<template>
	<div>
		<div :class="{ modal: true, show }">
			<AddQuestionModal v-if="type === 'addQuestions'" :data="payload" v-on:close="hideModal" />
			<EditQuestionModal v-if="type === 'editQuestions'" :data="payload" v-on:close="hideModal" />
		</div>
		<div :class="{ overlay: true, show }" v-on:click.prevent="hideModal"></div>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import AddQuestionModal from './AddQuestionModal';
import EditQuestionModal from './EditQuestionModal';

export default {
	components: {
		AddQuestionModal,
		EditQuestionModal,
	},
	computed: {
		...mapGetters('modal', [
			'show',
			'type',
			'payload',
		])
	},
	methods: {
		...mapActions('modal', [
			'hideModal'
		]),
	}
}
</script>

<style scoped>
.show {
	display: block;
}
</style>
