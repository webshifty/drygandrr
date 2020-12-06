<template>
<div class="sidebar-content">
	<span>Друг: {{ user.country }}</span>
	<div class="user">
		<img :src="user.photo" alt="">
		<div class="user-content">
			<div class="user-name">{{ user.name }}</div>
			<div class="user-email">{{ user.email }}</div>
		</div>
	</div>
	<div class="nav">
		<a :href="routes.requests" :class="{ active: isPage('requests') }" data-tab="1">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2.49984 3.2H16.6665C16.7382 3.2 16.7998 3.2616 16.7998 3.33333V8.33333C16.7998 8.40507 16.7382 8.46667 16.6665 8.46667H2.49984C2.4281 8.46667 2.3665 8.40507 2.3665 8.33333V3.33333C2.3665 3.2616 2.4281 3.2 2.49984 3.2ZM2.49984 11.5333H16.6665C16.7382 11.5333 16.7998 11.5949 16.7998 11.6667V16.6667C16.7998 16.7384 16.7382 16.8 16.6665 16.8H2.49984C2.4281 16.8 2.3665 16.7384 2.3665 16.6667V11.6667C2.3665 11.5949 2.4281 11.5333 2.49984 11.5333Z" stroke="#949494" stroke-width="1.4"/>
			</svg>                        
			<span>Керування питаннями</span>
		</a>
		<a :href="routes.questions" :class="{ active: isPage('questions') }" data-tab="2">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2.37484 5.00058V4.99999C2.37484 4.46535 2.80766 4.03333 3.33317 4.03333H16.6665C17.1966 4.03333 17.6332 4.46993 17.6332 4.99999V15C17.6332 15.5301 17.1966 15.9667 16.6665 15.9667H3.33317C2.80319 15.9667 2.36664 15.5302 2.3665 15.0002C2.3665 15.0002 2.3665 15.0001 2.3665 15L2.37484 5.00058Z" stroke="#252525" stroke-width="1.4"/>
				<path d="M2.5 5L10 10L17.5 5" stroke="#252525" stroke-width="1.4"/>
			</svg>
			<span>Запити</span>
		</a>
	</div>
	<div class="settings">
		<a :href="routes.settings" :class="{ active: isPage('settings') }">
			<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
				<path d="M5.00016 8.33333C4.0835 8.33333 3.3335 9.08333 3.3335 9.99999C3.3335 10.9167 4.0835 11.6667 5.00016 11.6667C5.91683 11.6667 6.66683 10.9167 6.66683 9.99999C6.66683 9.08333 5.91683 8.33333 5.00016 8.33333ZM15.0002 8.33333C14.0835 8.33333 13.3335 9.08333 13.3335 9.99999C13.3335 10.9167 14.0835 11.6667 15.0002 11.6667C15.9168 11.6667 16.6668 10.9167 16.6668 9.99999C16.6668 9.08333 15.9168 8.33333 15.0002 8.33333ZM10.0002 8.33333C9.0835 8.33333 8.3335 9.08333 8.3335 9.99999C8.3335 10.9167 9.0835 11.6667 10.0002 11.6667C10.9168 11.6667 11.6668 10.9167 11.6668 9.99999C11.6668 9.08333 10.9168 8.33333 10.0002 8.33333Z"/>
			</svg>                            
			<span>Налаштування</span>
		</a>
	</div>
	<div class="sidebar-bottom">
		<button class="sidebar-bottom__button" href="#" @click="logout">Вийти з системи</button>
	</div>
</div>
</template>

<script>
import { mapGetters } from 'vuex';
import requestService from '../../services/requestService';

export default {
	name: 'Sidebar',
	computed: {
		...mapGetters('user', [
			'user',
		]),
		...mapGetters('page', [
			'routeName',
			'routes',
		]),
	},
	methods: {
		isPage(page) {
			return this.routeName === page;
		},
		async logout() {
			await requestService.post(this.routes.logout);
			location.href = '/';
		}
	}
}
</script>

<style scoped>
.settings .active {
	color: #004BC1;
}

.settings svg {
	fill: #949494;
}

.settings .active svg {
	fill: #004BC1;
}

</style>
