<template>
<div class="container-fluid user">
	<div class="row">
		<div class="col-12">
			<div class="user__image">
				<img class="user__photo" :src="photo" alt="">
			</div>
			<div class="user__photo-links">
				<label
					href="#"
					class="user__link user__change-photo"
					for="change__photo"
				>
					<Pen fill="#004BC1" width="18" height="18" /><span>Замінити</span>
					<input id="change__photo" type="file" @change="onChangePhoto">
				</label>
				<a
					href="#"
					class="user__link user__delete-photo"
					@click.prevent="onDeletePhoto"
				>
					<Bucket fill="#EB5757" width="20" height="20" /><span>Видалити фото</span>
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<h3 class="user__name">{{ user.name }}</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="user__line">
				{{ access }}
			</div>
			<div class="user__line">
				Email: {{ user.email }}
			</div>
			<div class="user__line">
				Країна: {{ user.country }}
			</div>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-3">
			<button class="button secondary" @click.stop.prevent="onEdit">Редагувати</button>
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
			'user',
			'photo',
			'isAdmin'
		]),
		access() {
			return this.isAdmin ? 'Адміністратор' : 'Оператор'
		}
	},
	methods: {
		...mapActions('user', [
			'uploadPhoto',
			'deletePhoto',
		]),
		...mapActions('modal', [
			'showModal',
		]),
		onEdit() {
			this.showModal({
				type: 'updateUser',
				payload: {
					...this.user,
				}
			});
		},
		async onChangePhoto(e) {
			const file = e.target.files[0];
			e.target.value = "";
			await this.uploadPhoto(file);
		},
		async onDeletePhoto() {
			await this.deletePhoto();
		}
	}
}
</script>

<style scoped>
.user {
	padding: 0;
	display: block;
}
.user__image {
	float: left;
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
	font-size: 14px;
	font-weight: 700;
	display: inline;
	cursor: pointer;
}

.user__change-photo {
	color: #004BC1;
}

.user__change-photo input {
	display: none;
}

.user__photo-links {
	padding-top: 10px;
	padding-bottom: 10px;
}
.user__delete-photo {
	color: #EB5757;
}
.user__photo-input {
	display: none;
}

.user__name {
	margin-top: 30px;
	margin-bottom: 15px;
	font-size: 21px;
	font-weight: 700;
}

.user__line {
	background-color: #fff;
	padding: 25px 12px;
	font-size: 14px;
	color: #595959;
	border-bottom: 1px solid #EBEFF2;
} 
</style>
