<template>
<div class="container-fluid user">
	<div class="row">
		<div class="col-2">
			<img class="user__photo" :src="user.photo" alt="">
		</div>
		<div class="col-10 user__photo-links">
			<a
				href="#"
				class="user__link user__change-photo"
				@click.prevent
			>
				<Pen fill="#004BC1" width="18" height="18" /><span>Додати фото</span>
			</a>
			<a
				href="#"
				class="user__link user__delete-photo"
				@click.prevent
			>
				<Bucket fill="#EB5757" width="20" height="20" /><span>Видалити фото</span>
			</a>
		</div>
	</div>
</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Pen from './icons/Pen.vue';
import Bucket from './icons/Bucket.vue';

export default {
	components: {
		Pen,
		Bucket,
	},
	computed: {
		...mapGetters('user', [
			'user'
		])
	}
}
</script>

<style scoped>
.user {
	padding: 0;
	display: block;
}
.user__photo {
	width: 104px;
	height: 104px;
	border-radius: 50%;
}
.user__link {
	padding: 5px 0;
	white-space: nowrap;
	display: block;
}

.user__link span {
	padding: 0 10px;
}

.user__change-photo {
	color: #004BC1;
}

.user__photo-links {
	padding-top: 10px;
	padding-bottom: 10px;
}
.user__delete-photo {
	color: #EB5757;
}
</style>
