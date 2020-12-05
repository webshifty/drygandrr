<template>
	<Dashboard>
		<RequestsTable />
	</Dashboard>
</template>

<script>
import Dashboard from '../components/layouts/Dashboard';
import RequestsTable from '../components/RequestsTable';

export default {
	components: {
		Dashboard,
		RequestsTable,
	}
}
</script>
