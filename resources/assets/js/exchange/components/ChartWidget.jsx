import React, {Component} from 'react';

import {ChartCanvas, Chart} from "react-stockcharts";
import {PureComponent} from "react-stockcharts/es/lib/utils";
import PropTypes from "prop-types";

import {format} from "d3-format";
import {timeFormat} from "d3-time-format";

import {XAxis, YAxis} from "react-stockcharts/es/lib/axes";

import {CrossHairCursor, MouseCoordinateX, MouseCoordinateY} from "react-stockcharts/lib/coordinates";

import {discontinuousTimeScaleProvider} from "react-stockcharts/lib/scale";
import {last, toObject} from "react-stockcharts/lib/utils";
import {OHLCTooltip} from "react-stockcharts/es/lib/tooltip";
import {
	chartMargin, axisStyle, coordStyle, ohlcStyle, xhairStyle, styleFromType, barStyle, mainChart, secondaryChartHeight, styleFromTooltipType,
	fibStyle, trendStyle, eqdsStyle, stdevStyle, ganfanStyle
} from "../constants/ChartStyles";
import {chartFromType} from "../constants/ChartTypes";
import {settingFromType, transformForType} from "../constants/ChartSettings";

import {BarSeries} from "react-stockcharts/es/lib/series";
import {CurrentCoordinate} from "react-stockcharts/es/lib/coordinates";
import {FibonacciRetracement, GannFan, TrendLine, EquidistantChannel, StandardDeviationChannel, DrawingObjectSelector} from "react-stockcharts/es/lib/interactive";
import * as ToolTypes from "../constants/ToolTypes";

import {connect} from "react-redux";
import {bindActionCreators} from "redux";
import * as ChartActions from "../actions/ChartActions";

@connect((store) => {return {}}, (dispatch) => {
	return {
		setTool: bindActionCreators(ChartActions.setTool, dispatch),
	}
})
export default class ChartWidget extends PureComponent {
	static propTypes = {
		data: PropTypes.array.isRequired,
		width: PropTypes.number.isRequired,
		height: PropTypes.number.isRequired,
		settings: PropTypes.object,
		loadMore: PropTypes.func,
		tool: PropTypes.object,
	};

	state = {};

	componentDidMount() {
		document.addEventListener("keyup", this.onKeyPress);
	}

	componentWillUnmount() {
		document.removeEventListener("keyup", this.onKeyPress);
	}

	handleLoadMore = (start, end) => {
		if (this.props.loadMore) this.props.loadMore();
	};

	onKeyPress = (e) => {
		const keyCode = e.which;
		switch (keyCode) {
			case 46: {
				let state = {};
				for(const key in this.state) {
					state[key] = this.state[key].filter(each => !each.selected);
				}

				this.setState({...state});
				break;
			}
		}
	};

	onDrawToolComplete = (toolType, tool) => {
		if (this.props.tool.value !== ToolTypes.NONE.value) this.props.setTool(ToolTypes.NONE);
		this.setState({[toolType.value]: tool});
	};

	render() {
		let {width, height, data: initialData} = this.props;
		let {type, indicators} = this.props.settings;


		const MainChartSeries = chartFromType(type);
		const mainChartStyle = styleFromType(type);
		const mainChartSettings = settingFromType(type);
		let calculatedData = transformForType(type, initialData);

		let offset = {value: 24};
		let tooltips = {};
		for (let indicator of indicators) {
			calculatedData = indicator.calculator(calculatedData);
			tooltips[indicator.tooltipKey] = indicator.renderTooltip(offset, tooltips[indicator.tooltipKey]);
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
		                    onLoadMore={this.handleLoadMore}
		                    type="hybrid"
		                    seriesName="BTCUSDT">
			<CrossHairCursor snapX={true} {...xhairStyle}/>
			<Chart id={0} yExtents={d => [d.high, d.low]} {...mainChart}> {/*Main Chart*/}
				<YAxis axisAt="right" orient="right" ticks={5} {...axisStyle} {...yGrid}/>
				<XAxis axisAt="bottom" orient="bottom" ticks={8} {...axisStyle} {...xGrid}/>

				<MouseCoordinateX at="bottom" orient="bottom" displayFormat={timeFormat("%Y-%m-%d %H:%M")} {...coordStyle}/>
				<MouseCoordinateY at="right" orient="right" displayFormat={format(".2f")} {...coordStyle}/>

				<MainChartSeries {...mainChartSettings} {...mainChartStyle}/>

				{indicators.map((el) => el.render())}
				{Object.values(tooltips)}

				<OHLCTooltip forChart={0} origin={[0, 10]} {...ohlcStyle}/>
				{/*Tools*/}
				<FibonacciRetracement
					enabled={this.props.tool.value === ToolTypes.FIB.value} retracements={this.state[ToolTypes.FIB.value]}
					onComplete={(tool) => this.onDrawToolComplete(ToolTypes.FIB, tool)} {...fibStyle}/>
				<TrendLine
					enabled={this.props.tool.value === ToolTypes.TRENDLINE.value} trends={this.state[ToolTypes.TRENDLINE.value]}
					type="RAY"
					snap={false}
					snapTo={d => [d.high, d.low]} {...trendStyle}
					onComplete={(tool) => this.onDrawToolComplete(ToolTypes.TRENDLINE, tool)}/>
				<EquidistantChannel
					enabled={this.props.tool.value === ToolTypes.EQDC.value} channels={this.state[ToolTypes.EQDC.value]}
					onComplete={(tool) => this.onDrawToolComplete(ToolTypes.EQDC, tool)}  {...eqdsStyle}/>
				<StandardDeviationChannel
					enabled={this.props.tool.value === ToolTypes.STDEV.value} channels={this.state[ToolTypes.STDEV.value]}
					onComplete={(tool) => this.onDrawToolComplete(ToolTypes.STDEV, tool)} {...stdevStyle}/>
				<GannFan
					enabled={this.props.tool.value === ToolTypes.GANNFAN.value} fans={this.state[ToolTypes.GANNFAN.value]}
					onComplete={(tool) => this.onDrawToolComplete(ToolTypes.GANNFAN, tool)} {...ganfanStyle}/>
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