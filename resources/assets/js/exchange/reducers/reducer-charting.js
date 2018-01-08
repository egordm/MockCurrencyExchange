import {CHART_RESIZE, REQUEST_DATA_FULFILLED} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";
import * as IndicatorTypes from "../constants/IndicatorTypes";

const initialState = {
	width: 100,
	height: 100,
	charts: [
		{
			type: ChartTypes.CANDLESTICK,
			selectedTool: null,
			interval: '1d',
			indicators: [
				{
					type: IndicatorTypes.SMA,
					options: {
						windowSize: 20
					},
					style: {
						stroke: "#ffc400",
						strokeWidth: 2
					}
				},
				{
					type: IndicatorTypes.SMA,
					options: {
						windowSize: 99
					},
					style: {
						stroke: "#6600cc",
						strokeWidth: 2
					}
				},
				{
					type: IndicatorTypes.BOLL,
					options: {
						windowSize: 20
					},
					style: {
						stroke: {
							top: "#FFFFFF",
							middle: "#FFFFFF",
							bottom: "#FFFFFF",
						},
						fill: "#FFFFFF",
						opacity: 0.1,
						strokeWidth: 1
					}
				}
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
			let {width, height} = action.payload;
			return {...state, width, height};
		case REQUEST_DATA_FULFILLED:
			return {...state, data: action.payload};
		default:
			return state;
	}
}