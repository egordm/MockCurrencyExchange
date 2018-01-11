export function processCandles(data) {
	return data.map(el => {
		el.date = new Date(el.open_time * 1000);
		el.volume = parseFloat(el.volume);
		return el;
	})
}