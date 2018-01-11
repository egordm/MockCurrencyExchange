import {ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE, REQUEST_DATA, REQUEST_DATA_SUCCESS} from "../constants/ChartActionTypes";

export function resizeChart(width, height) {
	return {
		type: CHART_RESIZE,
		payload: {width, height}
	};
}

export function requestData(market, interval) {
	return {
		type: REQUEST_DATA,
		payload: {
			request:{
				url: `/markets/${market}/candlesticks?interval=${interval}`
			}
		}
	}
}

export function addIndicator(type, index) {
	return {
		type: ADD_INDICATOR,
		payload: {type, index}
	}
}

export function setInterval(interval) {
	return [
		(dispatch, getState) => {
			const market = getState().charting.market;
			dispatch(requestData(market, interval))
		},
		{
			type: SET_INTERVAL,
			payload: interval
		}
	]
}