<template>
	<div class="page">
		<div class="action-block">
			<div class="action-block__left">
				<div v-if="isAdmin" class="dropdown">
					<label for="filter-country">Країна:</label>
					<select id="filter-country" :value="filter.country" @change="onFilterCountry">
						<option value="">Усі</option>
						<option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
					</select>
				</div>
				<div class="dropdown">
					<label for="filter-category">Категорія:</label>
					<select id="filter-category" :value="filter.category" @change="onFilterCategory">
						<option value="">Усі</option>
						<option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
					</select>
				</div>
			</div>
			<div class="action-block__right">
				<div class="dropdown">
					<button class="button" v-on:click.prevent="onAdd">Додати</button>
					<div v-if="isAdmin" class="dropdown-menu" :class="{ show: showDropdown }">
						<a class="dropdown-item" href="#" @click.prevent="onAddCategory">Категорію</a>
						<a class="dropdown-item" href="#" @click.prevent="onAddQuestion">Запитання</a>
					</div>
				</div>
			</div>
		</div>
		<div class="table-container">
			<table class="table">
				<tr>
					<th class="table__header table__header--questions">Питання</th>
					<th>Відповіді</th>
					<th class="table__header table__header--control"></th>
				</tr>
				<tr
					class="table__row"
					v-for="question in questions"
					:key="question.id"
					@dblclick="onEdit(question.id)"
				>
					<td>{{ question.question }}</td>
					<td>{{ question.answer }}</td>
					<td>
						<a href="#" class="table__icon delete" @click.prevent.stop="onDelete(question.id)">
							<svg class="table__icon-image" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 3.2H16V4.8H14.4V15.2C14.4 15.4122 14.3157 15.6157 14.1657 15.7657C14.0157 15.9157 13.8122 16 13.6 16H2.4C2.18783 16 1.98434 15.9157 1.83431 15.7657C1.68429 15.6157 1.6 15.4122 1.6 15.2V4.8H0V3.2H4V0.8C4 0.587827 4.08429 0.384344 4.23431 0.234315C4.38434 0.0842854 4.58783 0 4.8 0H11.2C11.4122 0 11.6157 0.0842854 11.7657 0.234315C11.9157 0.384344 12 0.587827 12 0.8V3.2ZM12.8 4.8H3.2V14.4H12.8V4.8ZM5.6 7.2H7.2V12H5.6V7.2ZM8.8 7.2H10.4V12H8.8V7.2ZM5.6 1.6V3.2H10.4V1.6H5.6Z" fill="#EB5757"/>
							</svg>
						</a>

						<a href="#" class="table__icon edit" @click.prevent="onEdit(question.id)">
							<svg class="table__icon-image" width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.66667 13.0933H2.845L10.6067 5.47451L9.42833 4.31787L1.66667 11.9367V13.0933ZM15 14.7293H0V11.2585L11.1958 0.268795C11.3521 0.115444 11.564 0.0292969 11.785 0.0292969C12.006 0.0292969 12.2179 0.115444 12.3742 0.268795L14.7317 2.5829C14.8879 2.7363 14.9757 2.94432 14.9757 3.16122C14.9757 3.37812 14.8879 3.58615 14.7317 3.73954L5.2025 13.0933H15V14.7293ZM10.6067 3.16122L11.785 4.31787L12.9633 3.16122L11.785 2.00458L10.6067 3.16122Z"/>
							</svg>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<Pagination
			:total="meta.total"
			:page="meta.page"
			:perPage="meta.per_page"
			:lastPage="meta.last_page"
			@next="nextPage"
			@prev="prevPage"
		/>
	</div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Pagination from './tables/Pagination.vue';

export default {
	data() {
		return {
			showDropdown: false,
		};
	},
	components: {
		Pagination,
	},
	computed: {
		...mapGetters('questions', [
			'questions',
			'filter',
			'meta',
		]),
		...mapGetters('page', [
			'countries',
			'categories',
		]),
		...mapGetters('user', [
			'isOperator',
			'isAdmin',
		]),
	},

	methods: {
		...mapActions('modal', [
			'showModal',
		]),
		...mapActions('questions', [
			'getQuestions',
			'changeFilter',
			'nextPage',
			'prevPage',
		]),
		
		onEdit(questionId) {
			const question = this.questions.find(question => question.id === questionId);

			this.showModal({
				type: 'editQuestions',
				payload: {...question},
			});
		},
		onAdd() {
			if (this.isOperator) {
				this.onAddQuestion();
			} else if (this.isAdmin) {
				this.showDropdown = !this.showDropdown;
			}
		},
		onAddCategory() {
			this.showDropdown = false;
			this.showModal({
				type: 'addCateogory',
				payload: {
				}
			});
		},
		onAddQuestion() {
			this.showDropdown = false;
			this.showModal({
				type: 'addQuestions',
				payload: {
					country: '',
					category: '',
					status: "",
					question: "",
					answer: "",
					publish: false,
				}
			});
		},
		onDelete(questionId) {
			this.showModal({
				type: 'deleteQuestion',
				payload: {
					questionId
				},
			});
		},

		async onFilterCountry(e) {
			await this.changeFilter({
				filter: 'country',
				value: e.target.value,
			});
		},

		async onFilterCategory(e) {
			await this.changeFilter({
				filter: 'category',
				value: e.target.value,
			});
		}
	},
	async mounted() {
		await this.getQuestions();
	}
};
</script>

<style scoped>
.dropdown-item {
	color: #252525;
	font-size: 16px;
}

.dropdown-item:active {
	color: #fff;
}
</style>
