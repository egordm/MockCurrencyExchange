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

export const pollInterval = 20000;

export const defaultInterval = {label: '15 Minutes', value: '15m', length: 60 * 15};

export const intervalMinutes = [
	{label: '1 Minute', value: '1m', length: 60},
	{label: '5 Minutes', value: '5m', length: 60 * 5},
	{label: '15 Minutes', value: '15m', length: 60 * 15},
	{label: '30 Minutes', value: '30m', length: 60 * 30},
];

export const intervalHours = [
	{label: '1 Hour', value: '1h', length: 60 * 60},
	{label: '2 Hours', value: '2h', length: 60 * 60 * 2},
	{label: '4 Hours', value: '4h', length: 60 * 60 * 4},
	{label: '6 Hours', value: '6h', length: 60 * 60 * 6},
	{label: '12 Hours', value: '12h', length: 60 * 60 * 12},
];

export const intervalDays = [
	{label: '1 Day', value: '1d', length: 60 * 60 * 24},
	{label: '7 Days', value: '7d', length: 60 * 60 * 24 * 7},
];