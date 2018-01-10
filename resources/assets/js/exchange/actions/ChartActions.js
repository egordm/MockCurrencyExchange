import {ADD_INDICATOR, CHART_RESIZE, REQUEST_DATA} from "../constants/ChartActionTypes";
import {getCandleData} from "../utils/MockData";

export function resizeChart(width, height) {
	return {
		type: CHART_RESIZE,
		payload: {width, height}
	};
}

export function requestData() {
	return {
		type: REQUEST_DATA,
		payload: getCandleData()
	}
}

export function addIndicator(type, index) {
	return {
		type: ADD_INDICATOR,
		payload: {type, index}
	}
}