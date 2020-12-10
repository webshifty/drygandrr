<template>
	<div :class="{ modal: true, show }">
		<div class="modal__container">
			<AddQuestionModal v-if="type === 'addQuestions'" :data="payload" v-on:close="hideModal" />
			<EditQuestionModal v-if="type === 'editQuestions'" :data="payload" v-on:close="hideModal" />
			<DeleteQuestionModal v-if="type === 'deleteQuestion'" :data="payload" v-on:close="hideModal" />
			<AnswerUserModal v-if="type === 'answerUser'" :data="payload" v-on:close="hideModal" />
			<UpdateUserModal v-if="type === 'updateUser'" :data="payload" v-on:close="hideModal" />
			<UpdateWorkerModal v-if="type === 'updateWorker'" :data="payload" v-on:close="hideModal" />
			<DeleteWorkerModal v-if="type === 'deleteWorker'" :data="payload" v-on:close="hideModal" />
		</div>
		<div v-on:click.prevent="hideModal" class="overlay"></div>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import AddQuestionModal from './AddQuestionModal';
import DeleteQuestionModal from './DeleteQuestionModal.vue';
import EditQuestionModal from './EditQuestionModal';
import AnswerUserModal from './AnswerUserModal';
import UpdateUserModal from './UpdateUserModal.vue';
import UpdateWorkerModal from './UpdateWorkerModal.vue';
import DeleteWorkerModal from './DeleteWorkerModal.vue';

export default {
	components: {
		AddQuestionModal,
		EditQuestionModal,
		DeleteQuestionModal,
		AnswerUserModal,
		UpdateUserModal,
		UpdateWorkerModal,
		DeleteWorkerModal,
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
.modal {
    display: none;
    position: fixed;
	width: 100%;
	height: 100%;
	z-index: 10;
	top: 0;
}

.overlay {
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(4px);
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
}

.show {
	display: flex;
	justify-content: center;
	align-items: flex-start;
}

.modal__container {
	background-color: #fff;
    border-radius: 12px;
	padding: 52px 78px;
	z-index: 11;
	margin-top: 100px;
}
</style>
