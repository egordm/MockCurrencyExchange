import {tsvParse} from "d3-dsv";
import {timeParse} from "d3-time-format";
import {format} from "d3-format";

function parseData(parse) {
	return function (d) {
		d.date = parse(d.date);
		d.open = +d.open;
		d.high = +d.high;
		d.low = +d.low;
		d.close = +d.close;
		d.volume = +d.volume;

		return d;
	};
}

const parseDate = timeParse("%Y-%m-%d");

export function getCandleData() {
	return fetch("//rrag.github.io/react-stockcharts/data/MSFT.tsv")
		.then(response => response.text())
		.then(data => tsvParse(data, parseData(parseDate)));
}

export function getOpenOrders(count=30) {
	let ret = [];
	for(let i = 0; i < count; ++i) {
		ret.push({
			total: format("(.8f")(Math.random() * 1000),
			amount: format("(.4f")(Math.random() * 1000),
			price: format("(.2f")(Math.random() * (20000 - 14000) + 14000),
		});
	}
	return ret;
}

export function getOrderHistory(count=60) {
	let ret = [];
	for(let i = 0; i < count; ++i) {
		ret.push({
			time: '18:32:12',
			amount: format("(.3f")(Math.random() * 1000),
			price: format("(.2f")(Math.random() * (20000 - 14000) + 14000),
			type: Math.random() >= 0.5 ? 'buy' : 'sell'
		});
	}
	return ret;
}
