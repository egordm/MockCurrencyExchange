import React, {Component} from 'react';
import {areaSellStyle, areaStyle, axisStyle, chartMargin, chartSettingHeight, coordStyle, depthChart, mainChart, xhairStyle} from "../constants/ChartStyles";
import {ChartCanvas, Chart} from "react-stockcharts";
import {connect} from "react-redux";
import PropTypes from "prop-types";

import {CrossHairCursor, MouseCoordinateX, MouseCoordinateY} from "react-stockcharts/lib/coordinates";
import {last, first} from "react-stockcharts/lib/utils";
import {scaleLinear} from "d3-scale";
import LoaderWidget from "../components/LoaderWidget";
import {XAxis, YAxis} from "react-stockcharts/es/lib/axes";
import {format} from "d3-format";
import SpecialAreaSeries from "../vendor/SpecialAreaSeries";
import {curveStepAfter, curveStepBefore} from "d3-shape";


@connect((store) => {
	return {
		data: store.market_data.depth,
		market: store.market_data.market
	}
})
export default class DepthChart extends Component {
	static propTypes = {
		width: PropTypes.number.isRequired,
		height: PropTypes.number.isRequired,
	};

	render() {
		if (!this.props.data || this.props.data.length === 0) return <LoaderWidget/>;

		const {width, height, data} = this.props;

		const xExtents = [first(data).price, last(data).price];

		const gridHeight = height - chartMargin.top - chartMargin.bottom;
		const gridWidth = width - chartMargin.left - chartMargin.right;
		const yGrid = {innerTickSize: -1 * gridWidth, tickStrokeOpacity: 0.2};
		const xGrid = {innerTickSize: -1 * gridHeight, tickStrokeOpacity: 0.2};

		return <ChartCanvas ref={(el) => { this.canvas = el;}}
		                    data={data}
		                    width={width} height={height - chartSettingHeight} ratio={1} margin={chartMargin}
		                    xScale={scaleLinear()}
		                    xAccessor={d => {
			                    return d.price
		                    }}
		                    displayXAccessor={d => {
			                    return d.price
		                    }}
		                    xExtents={xExtents}
		                    onLoadMore={this.handleLoadMore}
		                    type="hybrid"
		                    seriesName="BTCUSDT">
			<CrossHairCursor snapX={false} {...xhairStyle}/>
			<Chart id={1} yExtents={d => [0, d.quantity]}
				yScale={scaleLinear()} {...depthChart}>

				<YAxis axisAt="right" orient="right" ticks={5} {...axisStyle} {...yGrid}/>
				<XAxis axisAt="bottom" orient="bottom" ticks={8} {...axisStyle} {...xGrid}/>

				<MouseCoordinateX snapX={false} at="bottom" orient="bottom"
				                  displayFormat={format(`(,.${this.props.market.valuta_primary.decimal_places}f`)} {...coordStyle}/>
				<MouseCoordinateY at="right" orient="right" displayFormat={format(".2f")} {...coordStyle}/>


				<SpecialAreaSeries interpolation={curveStepBefore} yAccessor={d => d.buy ? d.quantity : undefined} {...areaStyle}/>
				<SpecialAreaSeries interpolation={curveStepAfter} yAccessor={d => !d.buy ? d.quantity : undefined} {...areaSellStyle}/>
			</Chart>
		</ChartCanvas>;
	}
}