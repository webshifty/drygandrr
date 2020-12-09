<template>
	<WorkersTable />
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import WorkersTable from '../../components/WorkersTable.vue';

export default {
	components: {
		WorkersTable,
	},
}
</script>
