import React from "react";
import {LineSeries, BollingerSeries, SARSeries} from "react-stockcharts/es/lib/series";
import {CurrentCoordinate} from "react-stockcharts/es/lib/coordinates";

import * as IndicatorTypes from "../constants/IndicatorTypes";
import * as TooltipTypes from "../constants/TooltipTypes";

const linearIndicators = [IndicatorTypes.EMA.value, IndicatorTypes.SMA.value, IndicatorTypes.WMA.value, IndicatorTypes.TMA.value];

export default function (indicator) {
	const indentifier = indicator.type.value + Object.values(indicator.options).join('');
	const calculator = indicator.type.calculator().options(indicator.options).merge((d, c) => { d[indentifier] = c; }).accessor(d => d[indentifier]);

	if(linearIndicators.indexOf(indicator.type.value) > -1) {
		const elements = [
			<LineSeries key={indentifier} yAccessor={calculator.accessor()} {...indicator.style}/>,
			<CurrentCoordinate key={'coord-'+indentifier} yAccessor={calculator.accessor()} fill={indicator.style.stroke} />
		];
		const tooltip = {
			name: TooltipTypes.MATT.value,
			type: TooltipTypes.MATT,
			options: [
				{
					yAccessor: calculator.accessor(),
					type: IndicatorTypes.EMA.value,
					stroke: indicator.style.stroke,
					windowSize: calculator.options().windowSize,
				}
			]
		};
		return {calculator, elements, tooltip}; // TODO: tooltip
	}

	switch (indicator.type.value) {
		case IndicatorTypes.BOLL.value: {
			const elements = [
				<BollingerSeries key={indentifier} yAccessor={d => d[indentifier]} {...indicator.style}/>
			];
			const tooltip = {
				name: indentifier,
				type: TooltipTypes.BOLLTT,
				properties: {
					yAccessor: d => d[indentifier],
					options: calculator.options()
				},
			};
			return {calculator, elements, tooltip};
		}
		case IndicatorTypes.SAR.value: {
			const elements = [
				<SARSeries key={indentifier} yAccessor={d => d[indentifier]} {...indicator.style}/>
			];
			const tooltip = {
				name: indentifier,
				type: TooltipTypes.SINGLEVALUE,
				properties: {
					yAccessor: calculator.accessor(),
					yLabel: `SAR (${calculator.options().accelerationFactor}, ${calculator.options().maxAccelerationFactor})`,
				},
			};
			return {calculator, elements, tooltip};
		}
	}
}