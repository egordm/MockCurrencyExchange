export function processCandles(data) {
	return data.map(el => {
		el.date = new Date(el.open_time * 1000);
		el.volume = parseFloat(el.volume);
		return el;
	})
}

export function mergeCandles(oldData, newData) {
	if(!oldData) return newData;
	while(oldData[oldData.length - 1].close_time > newData[0].open_time) oldData.pop();
	return oldData.concat(newData);
}