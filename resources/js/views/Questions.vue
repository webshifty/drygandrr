<template>
	<Dashboard>
		<QuestionsTable />
	</Dashboard>
</template>

<script>
import Dashboard from '../components/layouts/Dashboard';
import QuestionsTable from '../components/QuestionsTable';

export default {
	components: {
		Dashboard,
		QuestionsTable,
	}
}
</script>
