import {ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE, REQUEST_DATA, POLL_DATA} from "../constants/ChartActionTypes";

export function resizeChart(width, height) {
	return {
		type: CHART_RESIZE,
		payload: {width, height}
	};
}

export function addIndicator(type, index) {
	return {
		type: ADD_INDICATOR,
		payload: {type, index}
	}
}

export function setInterval(interval) {
	return {
		type: SET_INTERVAL,
		payload: interval
	}
}

export function pollData(market, interval, last_updated) {
	let url = `/markets/${market}/candlesticks?interval=${interval.value}`;
	if (last_updated) {
		const end_time = parseInt(new Date().getTime() / 1000, 10);
		url += `&start_time=${last_updated}&end_time=${end_time}`
	}

	return {
		type: POLL_DATA,
		payload: {
			request: {
				url: url
			}
		}
	}
}
