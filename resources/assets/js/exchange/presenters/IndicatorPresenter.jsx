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
		if (!this.type) return;
		this._options = options;
		this._identifier = this.type.value + Object.values(this._options).join('');
		this._calculator = this.type.calculator().options(this._options).merge((d, c) => { d[this._identifier] = c; }).accessor(d => d[this._identifier]);
	}

	get calculator() {
		return this._calculator;
	}

	get options() {
		return this._options;
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

	getFillableOptions() {
		return [];
	}

	render() {
		return [];
	}

	renderTooltip(index, offset_ref = null, sibling = null, props = null) {
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

	getFillableOptions() {
		return [
			...super.getFillableOptions(),
			{label: 'Color', name: 'styling_stroke', type: 'color', format: 'string', value: this.styling.stroke},
			{label: 'Thickness', name: 'styling_strokeWidth', type: 'range', format: 'int', value: this.styling.strokeWidth, props: {max: 10, min: 1}},
			{label: 'Window Size', name: 'options_windowSize', type: 'number', format: 'int', value: this.calculator.options().windowSize},
		];
	}

	renderTooltip(index, offset_ref = null, sibling = null, props = null) {
		let offset = !offset_ref ? 0 : offset_ref.value;
		if (offset_ref && !sibling) offset_ref.value += 46;
		if (sibling) offset = sibling.props.origin[1];

		let options = !sibling ? [] : sibling.props.options;
		options.push({
			index: index,
			yAccessor: this.calculator.accessor(),
			type: this.type.value,
			stroke: this.styling.stroke,
			windowSize: this.calculator.options().windowSize,
		});

		return <MovingAverageTooltip key={this.tooltipKey} {...defaultTooltipStyle} {...this.tooltipProperties} options={options} origin={[0, offset]} {...props}/>;
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

	renderTooltip(index, offset_ref = null, sibling = null, props = null) {
		const offset = !offset_ref ? 0 : offset_ref.value;
		if (offset_ref) offset_ref.value += 22;
		const TooltipElement = this.tooltipElement;
		return <TooltipElement key={this.tooltipKey} {...defaultTooltipStyle} {...this.tooltipProperties} origin={[0, offset]} {...props}/>;
	}
}

export class BollBandIndicator extends SimpleIndicator {
	getFillableOptions() {
		return [
			...super.getFillableOptions(),
			{label: 'Stroke Top Color', name: 'styling_stroke_top', type: 'color', format: 'string', value: this.styling.stroke.top.toLowerCase()},
			{label: 'Stroke Mid Color', name: 'styling_stroke_middle', type: 'color', format: 'string', value: this.styling.stroke.middle.toLowerCase()},
			{label: 'Stroke Bottom Color', name: 'styling_stroke_bottom', type: 'color', format: 'string', value: this.styling.stroke.bottom.toLowerCase()},
			{label: 'Fill Color', name: 'styling_fill', type: 'color', format: 'string', value: this.styling.fill},
			{label: 'Thickness', name: 'styling_strokeWidth', type: 'range', format: 'int', value: this.styling.strokeWidth, props: {max: 10, min: 1}},
			{label: 'Opacity', name: 'styling_opacity', type: 'range', format: 'float', value: this.styling.opacity, props: {step: 0.01, max: 1, min: 0}},
			{label: 'Window Size', name: 'options_windowSize', type: 'number', format: 'int', value: this.calculator.options().windowSize},
		];
	}

	constructor(options = {}, styling = {}) {
		super(IndicatorTypes.BOLL, options, styling, BollingerSeries, BollingerBandTooltip, bollBandStyle);
	}
}

export class SARIndicator extends SimpleIndicator {
	getFillableOptions() {
		return [
			...super.getFillableOptions(),
			{label: 'Falling Color', name: 'styling_fill_falling', type: 'color', format: 'string', value: this.styling.fill.falling.toLowerCase()},
			{label: 'Rising Color', name: 'styling_fill_rising', type: 'color', format: 'string', value: this.styling.fill.rising.toLowerCase()},
			{label: 'Max Acceleration Factor', name: 'options_maxAccelerationFactor', type: 'range', format: 'float', value: this.calculator.options().maxAccelerationFactor, props: {step: 0.01, max: 1, min: 0}},
			{label: 'Acceleration Factor', name: 'options_accelerationFactor', type: 'range', format: 'float', value: this.calculator.options().accelerationFactor, props: {step: 0.01, max: 1, min: 0}},
		];
	}

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