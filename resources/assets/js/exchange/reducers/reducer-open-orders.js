import {getOpenOrders} from "../utils/MockData";


export default function () {
	return {
		bids: getOpenOrders(),
		asks: getOpenOrders()
	};
}