<template>
<div class="toolbar">
	<div class="text-lines">Рядків на сторінці: {{ perPage }}</div>
	<div class="pages">
		<span>{{ current }}-{{ total }}</span>
		<a class="prev__page page-button" :class="{ disabled: isFirst }" href="#" @click.prevent="onPrev">
			<svg width="6" height="13" viewBox="0 0 6 13" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9.83506e-07 6.5L6 0.00480921L6 12.9952L9.83506e-07 6.5Z"/>
			</svg>                       
		</a>
		<a class="next__page page-button" :class="{ disabled: isLast }" href="#" @click.prevent="onNext">
			<svg width="6" height="13" viewBox="0 0 6 13" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 6.5L-1.34912e-07 12.9952L4.32916e-07 0.00480912L6 6.5Z" />
			</svg>
		</a>
	</div>
</div>
</template>

<script>
import _ from 'lodash';

export default {
	props: {
		total: Number,
		page: Number,
		perPage: Number,
		lastPage: Number,
	},
	computed: {
		current() {
			if (this.isLast) {
				return this.total;
			}

			return (this.page * this.perPage);
		},
		isFirst() {
			return this.page === 1;
		},
		isLast() {
			return this.page === this.lastPage;
		}
	},
	methods: {
	},
	mounted() {
		this.onNext = _.throttle(() => {
			if (this.isLast) {
				return;
			}

			this.$emit('next');
		}, 500);
		this.onPrev = _.throttle(() => {
			if (this.isFirst) {
				return;
			}

			this.$emit('prev');
		}, 500);
	}
}
</script>

<style scoped>
.page-button {
	padding: 0px 10px;
}
</style>
