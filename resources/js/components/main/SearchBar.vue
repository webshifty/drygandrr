<template>
	<div>
		<div class="search">
			<label>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12.9167 11.6667H12.2583L12.025 11.4417C12.8417 10.4917 13.3333 9.25833 13.3333 7.91667C13.3333 4.925 10.9083 2.5 7.91667 2.5C4.925 2.5 2.5 4.925 2.5 7.91667C2.5 10.9083 4.925 13.3333 7.91667 13.3333C9.25833 13.3333 10.4917 12.8417 11.4417 12.025L11.6667 12.2583V12.9167L15.8333 17.075L17.075 15.8333L12.9167 11.6667ZM7.91667 11.6667C5.84167 11.6667 4.16667 9.99167 4.16667 7.91667C4.16667 5.84167 5.84167 4.16667 7.91667 4.16667C9.99167 4.16667 11.6667 5.84167 11.6667 7.91667C11.6667 9.99167 9.99167 11.6667 7.91667 11.6667Z" fill="#949494"/>
				</svg>
				<input name="search" type="text" placeholder="Пошук" @keydown="onSearch">
			</label>
		</div>
		<span class="notification"></span>
	</div>	
</template>

<script>
import _ from 'lodash';

export default {
	methods: {
		onSearch: _.debounce(function (e) {
			this.$emit('search', e.target.value);
		}, 300)
	},
}
</script>

<style scoped>
.search input {
    border: none;
    border-radius: 0;
	border-bottom: 1px solid #eaeaea;
	height: 60px;
}

.search {
    background-color: #fff;
}

.search input::placeholder {
    font-size: 14px;
    line-height: 17px;
    letter-spacing: 0.01em;
    color: #595959;
}

.search svg {
    margin: 0 0 0 30px;
}

.search label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.search input {
    border: 0;
    padding-right: 40px;
}

</style>
