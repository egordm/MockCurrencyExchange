import React, {Component} from 'react';

import {ChartCanvas, Chart} from "react-stockcharts";
import {PureComponent} from "react-stockcharts/es/lib/utils";
import PropTypes from "prop-types";

import {format} from "d3-format";
import {timeFormat} from "d3-time-format";

import {CandlestickSeries} from "react-stockcharts/es/lib/series";

import {XAxis, YAxis} from "react-stockcharts/es/lib/axes";

import {CrossHairCursor, MouseCoordinateX, MouseCoordinateY} from "react-stockcharts/lib/coordinates";

import {discontinuousTimeScaleProvider} from "react-stockcharts/lib/scale";
import {last} from "react-stockcharts/lib/utils/index";
import {OHLCTooltip} from "react-stockcharts/es/lib/tooltip";


export default class ChartWidget extends PureComponent {
	static propTypes = {
		data: PropTypes.array.isRequired,
		width: PropTypes.number.isRequired,
		height: PropTypes.number.isRequired,
	};

	render() {
		const {width, height, data: initData} = this.props;

		const xScaleProvider = discontinuousTimeScaleProvider.inputDateAccessor(d => d.date);
		const {data, xScale, xAccessor, displayXAccessor} = xScaleProvider(initData);

		const xExtents = [
			xAccessor(last(data)),
			xAccessor(data[data.length - 200])
		];


		return <ChartCanvas ref={(el) => { this.canvas = el;}}
		                    width={width} height={height} ratio={1}
		                    data={data}
		                    xScale={xScale}
		                    xAccessor={xAccessor}
		                    displayXAccessor={displayXAccessor}
		                    xExtents={xExtents}
		                    margin={{left: 0, right: 50, top: 0, bottom: 30}}
		                    type="hybrid"
		                    seriesName="BTCUSDT">
			<CrossHairCursor snapX={true} {...xhairStyle}/>
			<Chart id={0} yExtents={d => [d.high, d.low]}>
				<YAxis axisAt="right" orient="right" ticks={5} {...axisStyle}/>
				<XAxis axisAt="bottom" orient="bottom" {...axisStyle} ticks={8}/>

				<MouseCoordinateX at="bottom" orient="bottom" displayFormat={timeFormat("%Y-%m-%d %H:%M")} {...coordStyle}/>
				<MouseCoordinateY at="right" orient="right" displayFormat={format(".2f")} {...coordStyle}/>

				<CandlestickSeries {...seriesStyle} />

				<OHLCTooltip forChart={0} origin={[0, 10]} {...ohlcStyle}/>
			</Chart>
		</ChartCanvas>;
	}
}