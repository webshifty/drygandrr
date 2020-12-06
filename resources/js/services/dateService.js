
export default {
	formatDate(date) {
		const day = (date.getDate() + '').padStart(2, 0);
		const month = ((date.getMonth() + 1) + '').padStart(2, 0);
		const year = date.getFullYear();

		return `${day}.${month}.${year}`;
	},

	formatTime(date) {
		const hours = (date.getHours() + '').padStart(2, 0);
		const minutes = (date.getMinutes() + '').padStart(2, 0);

		return `${hours}:${minutes}`
	},

	getEnding(n) {
		const str = n + '';

		if (/1$/.test(str)) {
			return 'а';
		}

		if (/[234]$/.test(str) && !/^1/.test(str)) {
			return 'и';
		}

		return '';
	},

	formatHours(hours) {
		return `${hours} годин${this.getEnding(hours)} назад`;
	},

	formatMinutes(minutes) {
		return `${minutes} хвилин${this.getEnding(minutes)} назад`;
	},

	getFormatDate(strDate) {
		const A_MINUTE = 60 * 1000;
		const AN_HOUR = 60 * A_MINUTE;
		const date = new Date(strDate);
		const diff = (Date.now() - date);
		const hours = parseInt(diff / AN_HOUR);
		const minutes = parseInt(diff / A_MINUTE);

		if (hours > 24) {
			return `${this.formatDate(date)} о ${this.formatTime(date)}`;
		}

		if (hours >= 1) {
			return this.formatHours(hours);
		}

		if (minutes === 0) {
			return 'щойно';
		}

		return this.formatMinutes(minutes);
	}
}
