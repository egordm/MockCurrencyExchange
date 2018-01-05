import {format} from "d3-format";

export default function () {
	let ret = [];
	for(let i = 0; i < 60; ++i) {
		ret.push({
			time: '18:32:12',
			amount: format("(.3f")(Math.random() * 1000),
			price: format("(.2f")(Math.random() * (20000 - 14000) + 14000),
			type: Math.random() >= 0.5 ? 'buy' : 'sell'
		});
	}
	return ret;
}