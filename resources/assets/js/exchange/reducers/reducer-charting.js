import {ADD_INDICATOR, CHART_RESIZE, REQUEST_DATA_FULFILLED} from "../constants/ChartActionTypes";
import * as ChartTypes from "../constants/ChartTypes";
import * as IndicatorTypes from "../constants/IndicatorTypes";
import {createIndicator, LinearIndicator} from '../presenters/IndicatorPresenter';
import update from 'react-addons-update';
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
		case REQUEST_DATA_FULFILLED:
			return {...state, data: action.payload};
		case ADD_INDICATOR:
			return update(state, {
				charts: {
					[action.payload.index]: {
						indicators: {$push: [createIndicator(action.payload.type)]}
					}
				}
			});
		default:
			return state;
	}
}