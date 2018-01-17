import {SET_MARKET} from "../constants/ChartActionTypes";

export function setMarket(id, symbol) {
	return {
		type: SET_MARKET,
		payload: {id, symbol}
	}
}