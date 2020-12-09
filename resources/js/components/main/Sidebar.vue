<template>
<div class="sidebar-content">
	<span>Друг: {{ status }}</span>
	<div class="user">
		<img class="user__photo" :src="photo" alt="">
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
		<a v-if="isAdmin" :href="routes.workers" :class="{ active: isPage('workers') }" data-tab="3">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M18.8439 7.875C18.7065 9.78141 17.2923 11.25 15.7501 11.25C14.2079 11.25 12.7914 9.78188 12.6564 7.875C12.5157 5.89172 13.8925 4.5 15.7501 4.5C17.6078 4.5 18.9845 5.92781 18.8439 7.875Z" stroke="#949494" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M15.7498 14.25C12.695 14.25 9.75731 15.7673 9.02138 18.7223C8.92388 19.1133 9.16903 19.5 9.57075 19.5H21.9293C22.3311 19.5 22.5748 19.1133 22.4787 18.7223C21.7428 15.72 18.8051 14.25 15.7498 14.25Z" stroke="#949494" stroke-width="1.4" stroke-miterlimit="10"/>
				<path d="M9.37496 8.71594C9.26527 10.2384 8.12246 11.4375 6.89058 11.4375C5.65871 11.4375 4.51402 10.2389 4.40621 8.71594C4.29418 7.13203 5.40652 6 6.89058 6C8.37465 6 9.48699 7.16109 9.37496 8.71594Z" stroke="#949494" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M9.65622 14.3438C8.81012 13.9562 7.87825 13.8071 6.89059 13.8071C4.45309 13.8071 2.10466 15.0188 1.51638 17.379C1.43903 17.6912 1.63497 18.0001 1.9556 18.0001H7.21872" stroke="#949494" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"/>
			</svg>
			<span>Працівники</span>
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
		<a class="sidebar-bottom__button" href="#" @click.prevent="logout">
			Вийти з системи 
			<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 2.81829e-06 10 2.81829e-06C11.5527 -0.00116364 13.0842 0.359775 14.4729 1.05414C15.8617 1.74851 17.0693 2.75718 18 4H15.29C14.1352 2.98176 12.7112 2.31836 11.1887 2.0894C9.66625 1.86044 8.11007 2.07566 6.70689 2.70922C5.30371 3.34277 4.11315 4.36776 3.27807 5.66119C2.44299 6.95462 1.99887 8.46153 1.999 10.0011C1.99913 11.5407 2.4435 13.0475 3.27879 14.3408C4.11409 15.6341 5.30482 16.6589 6.7081 17.2922C8.11139 17.9255 9.66761 18.1405 11.19 17.9113C12.7125 17.6821 14.1364 17.0184 15.291 16H18.001C17.0702 17.243 15.8624 18.2517 14.4735 18.9461C13.0846 19.6405 11.5528 20.0013 10 20ZM17 14V11H9V9H17V6L22 10L17 14Z" />
			</svg>
		</a>
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
			'photo',
			'isAdmin',
		]),
		...mapGetters('page', [
			'routeName',
			'routes',
		]),

		status() {
			if (this.isAdmin) {
				return 'Адміністратор';
			} else {
				return this.user.country;
			}
		}
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
.nav a {
	border-left: 3px solid transparent;
}
.nav a:hover {
    background-color: #F6F8FE;
	color: #252525;
	border-left: 3px solid #555;
}
.settings .active {
	color: #004BC1;
}

.settings svg {
	fill: #949494;
}

.settings .active svg {
	fill: #004BC1;
}

.user__photo {
	border-radius: 50%;
	width: 47px;
	height: 47px;
}

</style>
