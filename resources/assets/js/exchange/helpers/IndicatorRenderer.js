import React from "react";
import { ema, sma, wma, tma, bollingerBand } from "react-stockcharts/lib/indicator";
import {LineSeries, BollingerSeries} from "react-stockcharts/es/lib/series";
import {CurrentCoordinate} from "react-stockcharts/es/lib/coordinates";

import * as IndicatorTypes from "../constants/IndicatorTypes";

const linearIndicators = {
	[IndicatorTypes.EMA.value]: ema,
	[IndicatorTypes.SMA.value]: sma,
	[IndicatorTypes.WMA.value]: wma,
	[IndicatorTypes.TMA.value]: tma,
};

export default function (indicator) {
	const indentifier = indicator.type.value + Object.values(indicator.options).join('');
	if(indicator.type.value in linearIndicators) {
		const calculator = linearIndicators[indicator.type.value]().options(indicator.options).merge((d, c) => { d[indentifier] = c; }).accessor(d => d[indentifier]);
		const elements = [
			<LineSeries yAccessor={calculator.accessor()} {...indicator.style}/>,
			<CurrentCoordinate yAccessor={calculator.accessor()} fill={indicator.style.stroke} />
		];
		return {calculator, elements}; // TODO: tooltip
	}

	switch (indicator.type.value) {
		case IndicatorTypes.BOLL.value: {
			const calculator = bollingerBand().options(indicator.options).merge((d, c) => { d[indentifier] = c; }).accessor(d => d[indentifier]);
			const elements = [
				<BollingerSeries yAccessor={d => d[indentifier]} {...indicator.style}/>
			];
			return {calculator, elements};
		}
	}
}