import {ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE, REQUEST_DATA_SUCCESS, REQUEST_DATA, POLL_DATA, POLL_DATA_SUCCESS} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";
import * as IndicatorTypes from "../constants/IndicatorTypes";
import {createIndicator, LinearIndicator} from '../presenters/IndicatorPresenter';
import update from 'react-addons-update';
import {processCandles, mergeCandles} from "../utils/DataProcessing";
import {defaultInterval} from "../constants/ChartSettings";

const initialState = {
	width: 100,
	height: 100,
	market: 'USD_BTC',
	interval: defaultInterval, // TODO: move interval into charts since we can stack charts
	last_updated: null,
	charts: [
		{
			type: ChartTypes.CANDLESTICK,
			selectedTool: null,
			interval: '1d',
			indicators: [
				new LinearIndicator(IndicatorTypes.SMA, {windowSize: 99}, {stroke: "#6600cc"}),
			],
			tools: [],
			settings: {
				showGrid: true
			}
		}
	],
};

export default function (state = initialState, action) {
	console.log(action);
	let data, last_updated;
	switch (action.type) {
		case CHART_RESIZE:
			const {width, height} = action.payload;
			return {...state, width, height};
		case POLL_DATA_SUCCESS:
			data = mergeCandles(state.data, processCandles(action.payload.data.data));
			last_updated = data[data.length - 1].open_time; // TODO: there might be an empty array which would be terrible
			return {...state, data: data, last_updated};
		case ADD_INDICATOR:
			return update(state, {
				charts: {
					[action.payload.index]: {
						indicators: {$push: [createIndicator(action.payload.type)]}
					}
				}
			});
		case SET_INTERVAL:
			return {...state, interval: action.payload};
		default:
			return state;
	}
}