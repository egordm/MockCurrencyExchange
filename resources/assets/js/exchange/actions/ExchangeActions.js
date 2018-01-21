import {HIDE_MESSAGE, SET_MARKET} from "../constants/ChartActionTypes";

export function setMarket(market) {
	return {
		type: SET_MARKET,
		payload: market
	}
}

export function hideMessageAction() {
	return {
		type: HIDE_MESSAGE,
	}
}