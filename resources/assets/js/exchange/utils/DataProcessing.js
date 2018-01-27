export function processCandles(data) {
	return data.map(el => {
		el.date = new Date(el.open_time * 1000);
		el.volume = parseFloat(el.volume);
		return el;
	})
}

// TODO: lots of duplicate data. Please clean up

export function mergeCandles(oldData, newData) {
	if(!oldData) return newData;
	if(!newData || newData.length === 0) return oldData;

	if(oldData && oldData.length > 0 && newData[newData.length - 1].open_time < oldData[oldData.length - 1].open_time) {
		while(oldData.length > 0 && oldData[0].close_time < newData[newData.length - 1].close_time) oldData.splice(0,1);
		return newData.concat(oldData);
	} else {
		while(oldData.length > 0 && oldData[oldData.length - 1].close_time >= newData[0].open_time) oldData.pop();
		return oldData.concat(newData);
	}
}

export function mergeBalance(oldData, newData) {
	if(!newData || newData.length === 0) return oldData;
	let ret = oldData ? {...oldData} : {};
	for(const balance of Object.values(newData)) ret[balance.valuta.id] = balance;
	return ret;
}

export function mergeOrders(oldData, newData) {
	if(!newData || newData.length === 0) return oldData;
	let ret = oldData ? {...oldData} : {};
	for(const order of newData) ret[order.id] = order;
	return ret;
}

export function mergeMarkets(oldData, newData) {
	if(!newData || newData.length === 0) return oldData;
	let ret = oldData ? {...oldData} : {};
	for(const market of newData) {
		ret[market.id] = {...market, symbol: `${market.valuta_primary.symbol}_${market.valuta_secondary.symbol}`};
	}
	return ret;
}

/*
export function mergeHistory(oldData, newData) {
	if(!oldData) return newData;
	if(!newData || newData.length === 0) return oldData;
	while(oldData.length > 0 && oldData[oldData.length - 1].time > newData[0].time) oldData.pop();
	return oldData.concat(newData); // TODO: merge ones with the same time
}*/

export function processDepth(data) {
	let asks = data.asks.sort((a, b) =>  a.price - b.price);
	let cumSum = 0;
	asks.slice(0).reverse().map((order) => {
		cumSum += order.quantity;
		order.quantity = cumSum;
		order['buy'] = true;
	});

	cumSum = 0;
	let bids = data.bids.sort((a, b) =>  a.price - b.price);
	bids.map((order) => {
		cumSum += order.quantity;
		order.quantity = cumSum;
		order['buy'] = false;
	});

	return asks.concat(bids);
}