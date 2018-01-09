import {CHART_RESIZE, REQUEST_DATA_FULFILLED} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";
import * as IndicatorTypes from "../constants/IndicatorTypes";
import {BollBandIndicator, LinearIndicator, SARIndicator} from '../presenters/IndicatorPresenter';
/*{
					type: IndicatorTypes.SAR,
					options: {},
					style: {
						fill: {
							falling: "#ff007a",
							rising: "#8ec919",
						},
					}
				}*/
/*{
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
		opacity: 0.08,
		strokeWidth: 1
	}
}*/

const initialState = {
	width: 100,
	height: 100,
	charts: [
		{
			type: ChartTypes.CANDLESTICK,
			selectedTool: null,
			interval: '1d',
			indicators: [
				new LinearIndicator(IndicatorTypes.EMA, {windowSize: 20}, {stroke: "#ffc400"}),
				new LinearIndicator(IndicatorTypes.SMA, {windowSize: 99}, {stroke: "#6600cc"}),
				new SARIndicator({}, {stroke: "#6600cc"}),
				new BollBandIndicator({windowSize: 20}, {}),
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