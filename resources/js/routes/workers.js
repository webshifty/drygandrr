import Workers from "../views/workers/Workers.vue";
import Worker from "../views/workers/Worker.vue";

export default [
	{
		path: '',
		component: Workers
	},
	{
		path: '/:id',
		component: Worker
	}
];