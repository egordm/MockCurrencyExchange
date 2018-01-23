import {
	ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE, REQUEST_DATA_SUCCESS, REQUEST_DATA, POLL_MARKET_DATA, POLL_MARKET_DATA_SUCCESS, SET_TOOL,
	EDIT_INDICATOR, SAVE_INDICATOR
} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";
import * as IndicatorTypes from "../constants/IndicatorTypes";
import {createIndicator, LinearIndicator} from '../presenters/IndicatorPresenter';
import update from 'react-addons-update';
import * as ToolTypes from "../constants/ToolTypes";


const initialState = {
	width: 100,
	height: 100,
	tool: ToolTypes.NONE,
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
	editing_indicator: null
};

export default function (state = initialState, action) {
	switch (action.type) {
		case CHART_RESIZE:
			const {width, height} = action.payload;
			return {...state, width, height};
		case ADD_INDICATOR:
			return update(state, {
				charts: {
					[action.payload.index]: {
						indicators: {$push: [createIndicator(action.payload.type)]}
					}
				}
			});
		case SET_TOOL:
			return {...state, tool: action.payload};
		case EDIT_INDICATOR:
			return {...state, editing_indicator: action.payload};
		case SAVE_INDICATOR:
			const newIndicator = createIndicator(action.payload.indicator.type, action.payload.indicator.options, action.payload.indicator.styling);
			return {
				...state,
				editing_indicator: null,
				charts: state.charts.map((el, i) => {
					if(i !== 0) return el;
					return {
						...el,
						indicators: el.indicators.map((el, i) => i === action.payload.index ? newIndicator : el)
					}
				})
			};
		default:
			return state;
	}
}