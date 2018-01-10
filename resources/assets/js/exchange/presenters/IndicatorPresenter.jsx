import React from "react";

import {LineSeries, BollingerSeries, SARSeries} from "react-stockcharts/es/lib/series";
import {CurrentCoordinate} from "react-stockcharts/es/lib/coordinates";

import * as IndicatorTypes from "../constants/IndicatorTypes";
import {bollBandStyle, defaultTooltipStyle, lineIndicatorStyle, sarStyle} from "../constants/ChartStyles";
import {BollingerBandTooltip, MovingAverageTooltip, SingleValueTooltip} from "react-stockcharts/es/lib/tooltip/index";


class IndicatorPresenter {
	constructor(type, options = {}, styling = {}) {
		this.type = type;
		this.styling = styling;
		this._options = null;
		this._calculator = null;
		this._identifier = null;
		this.setOptions(options);
	}

	setOptions(options) {
		if(!this.type) return;
		this._options = options;
		this._identifier = this.type.value + Object.values(this._options).join('');
		this._calculator = this.type.calculator().options(this._options).merge((d, c) => { d[this._identifier] = c; }).accessor(d => d[this._identifier]);
	}

	get calculator() {
		return this._calculator;
	}

	get identifier() {
		return this._identifier;
	}

	get tooltipProperties() {
		return {};
	}

	get tooltipKey() {
		return 'tooltip-' + this.identifier;
	}

	render() {
		return [];
	}

	renderTooltip(offset_ref = null, sibling = null) {
		return [];
	}
}

export class LinearIndicator extends IndicatorPresenter {
	constructor(type, options = {}, styling = {}) {
		styling = Object.assign({}, lineIndicatorStyle, styling);
		super(type, options, styling);
	}

	render() {
		return [
			<LineSeries key={this._identifier} yAccessor={this._calculator.accessor()} {...this.styling}/>,
			<CurrentCoordinate key={'coord-' + this._identifier} yAccessor={this._calculator.accessor()} fill={this.styling.stroke}/>
		]
	}

	get tooltipKey() {
		return 'tooltip-linear-indicators';
	}

	renderTooltip(offset_ref = null, sibling = null) {
		let offset = !offset_ref ? 0 : offset_ref.value;
		if(offset_ref && !sibling) offset_ref.value += 46;
		if(sibling) offset = sibling.props.origin[1];

		let options = !sibling ? [] : sibling.props.options;
		options.push({
			yAccessor: this.calculator.accessor(),
			type: IndicatorTypes.EMA.value,
			stroke: this.styling.stroke,
			windowSize: this.calculator.options().windowSize,
		});

		return <MovingAverageTooltip key={this.tooltipKey} {...defaultTooltipStyle} {...this.tooltipProperties} options={options} origin={[0, offset]}/>;
	}
}

class SimpleIndicator extends IndicatorPresenter {
	constructor(type, options, styling, element, tooltipElement, defaultStyle = {}) {
		styling = Object.assign({}, defaultStyle, styling);
		super(type, options, styling);
		this.element = element;
		this.tooltipElement = tooltipElement;
	}

	render() {
		const SeriesElement = this.element;
		return <SeriesElement key={this._identifier} yAccessor={d => d[this._identifier]} {...this.styling}/>;
	}

	get tooltipProperties() {
		return {
			yAccessor: d => d[this._identifier],
			options: this._calculator.options()
		};
	}

	renderTooltip(offset_ref = null) {
		const offset = !offset_ref ? 0 : offset_ref.value;
		if(offset_ref) offset_ref.value += 22;
		const TooltipElement = this.tooltipElement;
		return <TooltipElement key={this.tooltipKey} {...defaultTooltipStyle} {...this.tooltipProperties} origin={[0, offset]}/>;
	}
}

export class BollBandIndicator extends SimpleIndicator {
	constructor(options = {}, styling = {}) {
		super(IndicatorTypes.BOLL, options, styling, BollingerSeries, BollingerBandTooltip, bollBandStyle);
	}
}

export class SARIndicator extends SimpleIndicator {
	get tooltipProperties() {
		return {
			yAccessor: this._calculator.accessor(),
			yLabel: `SAR (${this._calculator.options().accelerationFactor}, ${this._calculator.options().maxAccelerationFactor})`,
		};
	}

	constructor(options = {}, styling = {}) {
		super(IndicatorTypes.SAR, options, styling, SARSeries, SingleValueTooltip, sarStyle);
	}
}

export function createIndicator(type, options = {}, styling = {}) {
	switch (type.value) {
		case IndicatorTypes.BOLL.value:
			return new BollBandIndicator(options, styling);
		case IndicatorTypes.SAR.value:
			return new SARIndicator(options, styling);
		default:
			return new LinearIndicator(type, options, styling);
	}
}