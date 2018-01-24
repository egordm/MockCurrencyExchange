import {ADD_INDICATOR, SET_INTERVAL, CHART_RESIZE, SET_TOOL, EDIT_INDICATOR, SAVE_INDICATOR, DELETE_INDICATOR} from "../constants/ChartActionTypes";

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

export function setTool(tool) {
	return {
		type: SET_TOOL,
		payload: tool
	}
}

export function editIndicator(index) {
	return {
		type: EDIT_INDICATOR,
		payload: index
	}
}

export function saveIndicator(index, indicator) {
	return {
		type: SAVE_INDICATOR,
		payload: {index, indicator}
	}
}

export function deleteIndicator(index) {
	return {
		type: DELETE_INDICATOR,
		payload: index
	}
}