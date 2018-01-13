import {POLL_DATA_SUCCESS, SET_INTERVAL, SET_MARKET} from "../constants/ChartActionTypes";
import {defaultInterval} from "../constants/ChartSettings";
import {mergeCandles, processCandles} from "../utils/DataProcessing";

const initialState = {
	market: 'USD_BTC',
	interval: defaultInterval,
	last_updated: null,
};

export default function (state = initialState, action) {
	switch (action.type) {
		case SET_MARKET:
			return {...state, data: null, last_updated: null, market: action.payload};
		case SET_INTERVAL:
			return {...state, data: null, last_updated: null, interval: action.payload};
		case POLL_DATA_SUCCESS:
			const data = mergeCandles(state.data, processCandles(action.payload.data.data));
			const last_updated = data[data.length - 1].open_time; // TODO: there might be an empty array which would be terrible
			return {...state, data: data, last_updated};
		default:
			return state;
	}
}