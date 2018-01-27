import React, {Component} from 'react';
import PropTypes from "prop-types";
import LineSeries from "react-stockcharts/es/lib/series/LineSeries";

import {curveStepAfter,} from "d3-shape";
import SpecialAreaOnlySeries from "./SpecialAreaOnlySeries";

export default class SpecialAreaSeries extends Component {
	static propTypes = {
		stroke: PropTypes.string,
		strokeWidth: PropTypes.number,
		fill: PropTypes.string.isRequired,
		opacity: PropTypes.number.isRequired,
		className: PropTypes.string,
		yAccessor: PropTypes.func.isRequired,
		baseAt: PropTypes.func,
		interpolation: PropTypes.func,
	};

	static defaultProps = {
		stroke: "#4682B4",
		strokeWidth: 1,
		opacity: 0.5,
		fill: "#4682B4",
		className: "react-stockcharts-area",
		interpolation: curveStepAfter
	};

	render() {
		const { yAccessor, baseAt } = this.props;
		const { className, opacity, stroke, strokeWidth, fill } = this.props;
		return (
			<g className={className}>
				<LineSeries
					yAccessor={yAccessor}
					stroke={stroke} fill="none"
					strokeWidth={strokeWidth}
					hoverHighlight={false} interpolation={this.props.interpolation} />
				<SpecialAreaOnlySeries
					yAccessor={yAccessor}
					base={baseAt}
					stroke="none" fill={fill}
					opacity={opacity} interpolation={this.props.interpolation}/>
			</g>
		);
	}
}