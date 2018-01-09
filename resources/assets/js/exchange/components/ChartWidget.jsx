import React, {Component} from 'react';

import {ChartCanvas, Chart} from "react-stockcharts";
import {PureComponent} from "react-stockcharts/es/lib/utils";
import PropTypes from "prop-types";

import {format} from "d3-format";
import {timeFormat} from "d3-time-format";

import {XAxis, YAxis} from "react-stockcharts/es/lib/axes";

import {CrossHairCursor, MouseCoordinateX, MouseCoordinateY} from "react-stockcharts/lib/coordinates";

import {discontinuousTimeScaleProvider} from "react-stockcharts/lib/scale";
import {last} from "react-stockcharts/lib/utils/index";
import {OHLCTooltip} from "react-stockcharts/es/lib/tooltip";
import {chartMargin, axisStyle, coordStyle, ohlcStyle, xhairStyle, styleFromType, barStyle, mainChart, secondaryChartHeight, styleFromTooltipType} from "../constants/ChartStyles";
import {chartFromType} from "../constants/ChartTypes";
import {settingFromType, transformForType} from "../constants/ChartSettings";

import IndicatorRenderer from '../helpers/IndicatorRenderer'

import {BarSeries} from "react-stockcharts/es/lib/series";
import {CurrentCoordinate} from "react-stockcharts/es/lib/coordinates";
import * as TooltipRenderer from "../helpers/TooltipRenderer";

export default class ChartWidget extends PureComponent {
	static propTypes = {
		data: PropTypes.array.isRequired,
		width: PropTypes.number.isRequired,
		height: PropTypes.number.isRequired,
		settings: PropTypes.object,
	};

	render() {
		let {width, height, data: initialData} = this.props;
		let {type, indicators} = this.props.settings;


		const MainChartSeries = chartFromType(type);
		const mainChartStyle = styleFromType(type);
		const mainChartSettings = settingFromType(type);
		let calculatedData = transformForType(type, initialData);

		let elements = [];
		let tooltips = {};
		for (let indicator of indicators) {
			const {calculator, elements: els, tooltip} = IndicatorRenderer(indicator);
			elements.push(els);
			calculatedData = calculator(calculatedData);
			if (tooltip !== null) {
				if (tooltip.name in tooltips) tooltips[tooltip.name].options = tooltips[tooltip.name].options.concat(tooltip.options);
				else tooltips[tooltip.name] = tooltip;
			}
		}

		const xScaleProvider = discontinuousTimeScaleProvider.inputDateAccessor(d => d.date);
		const {data, xScale, xAccessor, displayXAccessor} = xScaleProvider(calculatedData);

		const xExtents = [xAccessor(last(data)), xAccessor(data[Math.max(0, data.length - 200)])];

		const gridHeight = height - chartMargin.top - chartMargin.bottom;
		const gridWidth = width - chartMargin.left - chartMargin.right;
		const yGrid = {innerTickSize: -1 * gridWidth, tickStrokeOpacity: 0.2};
		const xGrid = {innerTickSize: -1 * gridHeight, tickStrokeOpacity: 0.2};

		return <ChartCanvas ref={(el) => { this.canvas = el;}}
		                    width={width} height={height} ratio={1} margin={chartMargin}
		                    data={data}
		                    xScale={xScale}
		                    xAccessor={xAccessor}
		                    displayXAccessor={displayXAccessor}
		                    xExtents={xExtents}
		                    type="hybrid"
		                    seriesName="BTCUSDT">
			<CrossHairCursor snapX={true} {...xhairStyle}/>
			<Chart id={0} yExtents={d => [d.high, d.low]} {...mainChart}> {/*Main Chart*/}
				<YAxis axisAt="right" orient="right" ticks={5} {...axisStyle} {...yGrid}/>
				<XAxis axisAt="bottom" orient="bottom" ticks={8} {...axisStyle} {...xGrid}/>

				<MouseCoordinateX at="bottom" orient="bottom" displayFormat={timeFormat("%Y-%m-%d %H:%M")} {...coordStyle}/>
				<MouseCoordinateY at="right" orient="right" displayFormat={format(".2f")} {...coordStyle}/>

				<MainChartSeries {...mainChartSettings} {...mainChartStyle}/>

				{elements}

				{TooltipRenderer.renderMultiple(tooltips, 24)}

				<OHLCTooltip forChart={0} origin={[0, 10]} {...ohlcStyle}/>
			</Chart>
			<Chart id={1} yExtents={[d => d.volume]} height={secondaryChartHeight} origin={(w, h) => [0, h - secondaryChartHeight]}>
				<YAxis axisAt="left" orient="left" ticks={5} tickFormat={format(".2s")} {...axisStyle} />

				<MouseCoordinateY at="left" orient="left" displayFormat={format(".4s")} {...coordStyle}/>

				<BarSeries yAccessor={d => d.volume} {...barStyle} />
				<CurrentCoordinate yAccessor={d => d.volume} fill="#9B0A47"/>
			</Chart>
		</ChartCanvas>;
	}
}