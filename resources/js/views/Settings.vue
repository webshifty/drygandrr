<template>
	<Dashboard @search="onSearch">
		<SettingsFrom />
	</Dashboard>
</template>

<script>
import { mapActions } from 'vuex';
import Dashboard from '../components/layouts/Dashboard';
import SettingsFrom from '../components/SettingsFrom';

export default {
	components: {
		Dashboard,
		SettingsFrom,
	}
}
</script>
