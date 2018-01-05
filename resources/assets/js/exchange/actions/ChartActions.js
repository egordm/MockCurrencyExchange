import {CHART_RESIZE} from "../constants/ChartActionTypes";

export function resizeChart(width, height) {
	return {
		type: CHART_RESIZE,
		payload: {width, height}
	};
}