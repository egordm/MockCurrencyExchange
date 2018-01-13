import {
	CANCEL_ORDER_SUCCESS,
	CREATE_ORDER_SUCCESS, GET_BALANCE_SUCCESS, GET_MARKETS_SUCCESS, GET_ORDERS_SUCCESS, LOGIN_SUCCESS, LOGOUT_SUCCESS, POLL_DATA_SUCCESS, SET_INTERVAL,
	SET_MARKET
} from "../constants/ChartActionTypes";
import {defaultInterval} from "../constants/ChartSettings";
import {mergeBalance, mergeCandles, mergeMarkets, mergeOrders, processCandles} from "../utils/DataProcessing";

const initialState = {
	market: 'USD_BTC',
	interval: defaultInterval,
	last_polled: null,

	logged_in: false,
	balance: [],
	orders: [],
	markets: []
};

export default function (state = initialState, action) {
	console.log(action);
	switch (action.type) {
		case SET_MARKET:
			return {...state, data: null, last_polled: null, market: action.payload};
		case SET_INTERVAL:
			return {...state, data: null, last_polled: null, interval: action.payload};
		case POLL_DATA_SUCCESS:
			const data = mergeCandles(state.data, processCandles(action.payload.data.data));
			const last_polled = data.length !== 0 ? data[data.length - 1].open_time : state.last_polled;
			return {...state, data, last_polled};
		case LOGIN_SUCCESS:
			return {...state, logged_in: true};
		case LOGOUT_SUCCESS:
			return {...state, logged_in: false, balance: [], orders: []};
		case GET_BALANCE_SUCCESS:
			return {...state, balance: mergeBalance(state.balance, action.payload.data.data)};
		case GET_ORDERS_SUCCESS:
			return {...state, orders: mergeOrders(state.orders, action.payload.data.data)};
		case CREATE_ORDER_SUCCESS:
			return {...state, orders: {...state.orders, [action.payload.data.data.id]: action.payload.data.data}};
		case CANCEL_ORDER_SUCCESS:
			return {...state, orders: {...state.orders, [action.payload.data.data.id]: action.payload.data.data}};
		case GET_MARKETS_SUCCESS:
			return {...state, markets: mergeMarkets(state.markets, action.payload.data.data)};
		default:
			return state;
	}
}