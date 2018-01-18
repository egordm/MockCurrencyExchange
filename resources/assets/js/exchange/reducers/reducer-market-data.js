import { GET_MARKETS_SUCCESS, POLL_MARKET_DATA_SUCCESS, SET_INTERVAL, SET_MARKET} from "../constants/ChartActionTypes";
import {defaultInterval} from "../constants/ChartSettings";
import {mergeCandles, mergeHistory, mergeMarkets, processCandles} from "../utils/DataProcessing";

const initialState = {
	last_polled: null,
	market: {symbol: 'USD_BTC', id: 1},

	// Market data
	interval: defaultInterval,
	candles: null,
	depth: null,
	history: null,

	// Global data
	markets: null
};

export default function (state = initialState, action) {
	switch (action.type) {
		case SET_MARKET:
			return {...state, data: null, last_polled: null, history: null, depth: null, candles: null, market: action.payload};
		case SET_INTERVAL:
			return {...state, data: null, last_polled: null, interval: action.payload};
		case POLL_MARKET_DATA_SUCCESS:
			const candles = mergeCandles(state.candles, processCandles(action.payload.data.data.candles));
			const depth = action.payload.data.data.depth;
			const history = mergeHistory(state.history, action.payload.data.data.history);
			const last_polled = candles.length !== 0 ? candles[candles.length - 1].open_time : state.last_polled;
			return {...state, candles, depth, history, last_polled};
		case GET_MARKETS_SUCCESS:
			return {...state, markets: mergeMarkets(state.markets, action.payload.data.data)};
		default:
			return state;
	}
}