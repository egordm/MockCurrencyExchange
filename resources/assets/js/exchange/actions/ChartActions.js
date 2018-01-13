import {ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE} from "../constants/ChartActionTypes";

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