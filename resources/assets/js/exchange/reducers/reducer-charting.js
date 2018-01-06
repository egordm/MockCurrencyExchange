import {CHART_RESIZE, REQUEST_DATA_FULFILLED} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";

const initialState = {
	width: 100,
	height: 100,
	charts: [
		{
			type: ChartTypes.CANDLESTICK,
			selectedTool: null,
			interval: '1d',
			indicators: [],
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
			let {width, height} = action.payload;
			return {...state, width, height};
		case REQUEST_DATA_FULFILLED:
			return {...state, data: action.payload};
		default:
			return state;
	}
}