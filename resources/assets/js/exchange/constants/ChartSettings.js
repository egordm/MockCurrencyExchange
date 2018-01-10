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

export const intervalMinutes = [
	{label: '1 Minute', value: '1m'},
	{label: '5 Minutes', value: '5m'},
	{label: '15 Minutes', value: '15m'},
	{label: '30 Minutes', value: '30m'},
];

export const intervalHours = [
	{label: '1 Hour', value: '1h'},
	{label: '2 Hours', value: '2h'},
	{label: '4 Hours', value: '4h'},
	{label: '6 Hours', value: '6h'},
	{label: '12 Hours', value: '12h'},
];

export const intervalDays = [
	{label: '1 Day', value: '1d'},
	{label: '7 Days', value: '7d'},
];