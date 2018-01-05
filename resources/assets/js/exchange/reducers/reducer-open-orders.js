import {format} from "d3-format";

const generateOrders = () => {
	let ret = [];
	for(let i = 0; i < 60; ++i) {
		ret.push({
			total: format("(.8f")(Math.random() * 1000),
			amount: format("(.4f")(Math.random() * 1000),
			price: format("(.2f")(Math.random() * (20000 - 14000) + 14000),
		});
	}
	return ret;
};

export default function () {
	return {
		bids: generateOrders(),
		asks: generateOrders()
	};
}