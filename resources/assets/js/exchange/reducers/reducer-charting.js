import {ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE, REQUEST_DATA_SUCCESS} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";
import * as IndicatorTypes from "../constants/IndicatorTypes";
import {createIndicator, LinearIndicator} from '../presenters/IndicatorPresenter';
import update from 'react-addons-update';
import {processCandles} from "../utils/DataProcessing";

const initialState = {
	width: 100,
	height: 100,
	market: 'USD_BTC',
	interval: '15m', // TODO: move interval into charts since we can stack charts
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
	switch (action.type) {
		case CHART_RESIZE:
			const {width, height} = action.payload;
			return {...state, width, height};
		case REQUEST_DATA_SUCCESS:
			return {...state, data: processCandles(action.payload.data.data)};
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