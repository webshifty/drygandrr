<template>
<div>
	<div class="wrapper">
		<div class="sidebar">
			<Sidebar />
		</div>
		<SearchBar />
		<div class="content active" data-tab="1">
			<Alert />
			<slot></slot>
		</div>
	</div>
	<Modal />
</div>
</template>

<script>
import { mapActions } from 'vuex';
import Sidebar from '../main/Sidebar.vue';
import SearchBar from '../main/SearchBar.vue';
import Modal from '../modals/Modal.vue';
import Alert from '../alerts/Alert';

export default {
	components: {
		Sidebar,
		SearchBar,
		Modal,
		Alert,
	},
	methods: {
		...mapActions('alerts', [
			'error',
		])
	},
	errorCaptured(err, vm, info) {
    	this.error({ message: err.message });
  }
}
</script>