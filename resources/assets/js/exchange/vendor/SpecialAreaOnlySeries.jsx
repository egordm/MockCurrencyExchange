import React, {Component} from 'react';
import {area as d3Area} from "d3-shape";
import {functor, hexToRGBA, isDefined, first} from "react-stockcharts/es/lib/utils";
import PropTypes from "prop-types";
import GenericChartComponent from "react-stockcharts/es/lib/GenericChartComponent";
import {getAxisCanvas} from "react-stockcharts/es/lib/GenericComponent";
import {curveStepAfter, curveStepBefore} from "d3-shape";


export default class SpecialAreaOnlySeries extends Component {
	static propTypes = {
		className: PropTypes.string,
		yAccessor: PropTypes.func.isRequired,
		stroke: PropTypes.string,
		fill: PropTypes.string,
		opacity: PropTypes.number,
		defined: PropTypes.func,
		base: PropTypes.oneOfType([
			PropTypes.func, PropTypes.number
		]),
		interpolation: PropTypes.func,
	};


	static defaultProps = {
		className: "line ",
		fill: "none",
		opacity: 1,
		defined: d => !isNaN(d),
		base: (yScale /* , d, moreProps */) => first(yScale.range()),
		interpolation: null
	};

	constructor(props) {
		super(props);
		this.renderSVG = this.renderSVG.bind(this);
		this.drawOnCanvas = this.drawOnCanvas.bind(this);
	}

	drawOnCanvas(ctx, moreProps) {
		const {yAccessor, defined, base} = this.props;
		const {fill, stroke, opacity} = this.props;

		const {xScale, chartConfig: {yScale}, plotData, xAccessor} = moreProps;

		const newBase = functor(base);

		ctx.fillStyle = hexToRGBA(fill, opacity);
		ctx.strokeStyle = stroke;

		let points0 = [], points1 = [];

		for (let i = 0; i < plotData.length; i++) {
			const d = plotData[i];
			if (defined(yAccessor(d), i)) {
				const [x, y1, y0] = [xScale(xAccessor(d)), yScale(yAccessor(d)), newBase(yScale, d, moreProps)];

				points0.push([x, y0]);
				points1.push([x, y1]);
			} else if (points0.length) {
				segment(points0, points1, ctx, this.props.interpolation);
				points0 = [];
				points1 = [];
			}
		}
		if (points0.length) segment(points0, points1, ctx, this.props.interpolation);
	}

	renderSVG(moreProps) {
		const {yAccessor, defined, base} = this.props;
		const {stroke, fill, className, opacity, interpolation} = this.props;

		const {xScale, chartConfig: {yScale}, plotData, xAccessor} = moreProps;

		const newBase = functor(base);
		const areaSeries = d3Area()
			.defined(d => defined(yAccessor(d)))
			.x((d) => xScale(xAccessor(d)))
			.y0((d) => newBase(yScale, d, moreProps))
			.y1((d) => yScale(yAccessor(d)));

		if (isDefined(interpolation)) {
			areaSeries.curve(interpolation);
		}

		const d = areaSeries(plotData);
		const newClassName = className.concat(isDefined(stroke) ? "" : " line-stroke");
		return (
			<path d={d} stroke={stroke} fill={fill} className={newClassName} opacity={opacity}/>
		);
	}

	render() {
		return <GenericChartComponent
			svgDraw={this.renderSVG}
			canvasDraw={this.drawOnCanvas}
			canvasToDraw={getAxisCanvas}
			drawOn={["pan"]}
		/>;
	}
}

function segment(points0, points1, ctx, interpolation) {
	ctx.beginPath();
	const [x0, y0] = first(points0);
	ctx.moveTo(x0, y0);

	let i;
	for (i = 0; i < points1.length; i++) {
		const [x1, y1] = points1[i];

		if(i > 0 && interpolation === curveStepAfter) {
			const [x2, y2] = points1[i - 1];
			ctx.lineTo(x1, y2);
		}

		ctx.lineTo(x1, y1);

		if(i < points1.length - 1 && interpolation === curveStepBefore) {
			const [x2, y2] = points1[i + 1];
			ctx.lineTo(x1, y2);
		}
	}

	for (i = points0.length - 1; i >= 0; i--) {
		const [x0, y0] = points0[i];
		ctx.lineTo(x0, y0);
	}
	ctx.closePath();
	ctx.fill();
}
