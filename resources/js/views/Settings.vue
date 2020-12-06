<template>
	<Dashboard>
		<SettingsForm />
	</Dashboard>
</template>

<script>
import { mapActions } from 'vuex';
import Dashboard from '../components/layouts/Dashboard';
import SettingsForm from '../components/SettingsForm';

export default {
	components: {
		Dashboard,
		SettingsForm,
	}
}
</script>
