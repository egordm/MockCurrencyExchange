import {AREA, CANDLESTICK, HEIKIN_ASHI, KAGI, LINE} from "./ChartTypes";

export function settingFromType(type) {
	switch (type.value) {
		case AREA.value: {
			return {yAccessor: d => d.close};
		}
		case LINE.value: {
			return {yAccessor: d => d.close};
		}
		default:
			return {};
	}
}

import {kagi, heikinAshi} from "react-stockcharts/lib/indicator";


export function transformForType(type, data) {
	switch (type.value) {
		case KAGI.value: {
			const calculator = kagi().options({ windowSize: 1 });
			return calculator(data);
		}
		case HEIKIN_ASHI.value: {
			const calculator = heikinAshi();
			return calculator(data);
		}
		default:
			return data;
	}
}