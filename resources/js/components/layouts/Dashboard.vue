<template>
<div>
	<div class="wrapper">
		<div class="sidebar">
			<Sidebar />
		</div>
		<div class="main">
			<div class="top">
				<SearchBar @search="$emit('search', $event)" />
			</div>	
			<div class="content active" data-tab="1">
				<Alert />
				<slot></slot>
			</div>
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

<style scoped>
.wrapper {
    min-height: 100vh;
	background: #F6F8FE;
	display: flex;
	align-items: stretch;
}

.sidebar {
	min-width: 256px;
	max-width: 256px;
    height: 100vh;
    background-color: #fff;
	box-shadow: 6px 0px 18px rgba(0, 0, 0, 0.06);
	z-index: 2;
	position: fixed;
}

.main {
	width: 100%;
	margin-left: 256px;
}

.search {
    background-color: #fff;
}

.search input::placeholder {
    font-size: 14px;
    line-height: 17px;
    letter-spacing: 0.01em;
    color: #595959;
}

.search svg {
    margin: 0 0 0 30px;
}

.search label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.search input {
    border: 0;
    padding-right: 40px;
}

.top {
    height: 60px;
}

.content {
    padding: 36px;
}
</style>
