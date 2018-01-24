import {AREA, CANDLESTICK, HEIKIN_ASHI, KAGI, LINE, POINT_FIGURE, RENKO} from "./ChartTypes";

export const chartSettingHeight = 34;

export const chartMargin = {left: 30, right: 50, top: 0, bottom: 30};

export const secondaryChartHeight = 100;

export const mainChart = {
	padding: {
		top: 0,
		bottom: secondaryChartHeight + 5
	}
};

export const axisStyle = {
	stroke: "#00000000",
	tickStroke: "#7d7f81",
	innerTickSize: 0,
	fontSize: 11,
	fontFamily: "'Roboto Condensed', sans-serif"
};

export const ohlcStyle = {
	fontSize: 14,
	fontFamily: "'Roboto', sans-serif",
	textFill: "#FFFFFF",
	labelFill: "#7d7f81"
};

export const xhairStyle = {
	stroke: "#FFFFFF",
	opacity: 0.4,
};

export const coordStyle = {
	fontFamily: "'Roboto Condensed', sans-serif",
	fontSize: 11,
};

export const candlestickStyle = {
	stroke: d => d.close > d.open ? "#8ec919" : "#ff007a",
	wickStroke: d => d.close > d.open ? "#8ec919" : "#ff007a",
	fill: d => d.close > d.open ? "#8ec91900" : "#ff007a",
	candleStrokeWidth: 1,
	widthRatio: 0.7,
	opacity: 1
};

export const lineStyle = {
	stroke: "#ffffff"
};

export const kagiStyle = {
	stroke: {
		yang: "#8ec919",
		yin: "#ff007a"
	},
};

export const areaStyle = {
	stroke: "#8ec919",
	fill: "#8ec919",
	opacity: 0.2
};

export const barStyle = {
	fill: d => d.close > d.open ? "#8ec919" : "#ff007a",
	opacity: 0
};

export function styleFromType(type) {
	switch (type.value) {
		case AREA.value: {
			return areaStyle;
		}
		case LINE.value: {
			return lineStyle;
		}
		case CANDLESTICK.value: {
			return candlestickStyle;
		}
		case HEIKIN_ASHI.value: {
			return candlestickStyle;
		}
		default:
			return {};
	}
}

export const defaultTooltipStyle = {
	textFill: "#FFFFFF",
	labelFill: "#7d7f81",
	valueFill: "#FFFFFF",
	fontSize: 12,
	fontFamily: "'Roboto', sans-serif",
};

export const bollBandStyle = {
	stroke: {
		top: "#FFFFFF",
		middle: "#FFFFFF",
		bottom: "#FFFFFF",
	},
	fill: "#FFFFFF",
	opacity: 0.08,
	strokeWidth: 1
};

export const sarStyle = {
	fill: {
		falling: "#ff007a",
		rising: "#8ec919",
	},
};

export const lineIndicatorStyle = {
	strokeWidth: 2,
	stroke: "#ffc400",
};


export const fibStyle = {
	currentPositionStroke: "#219fda",
	currentPositionStrokeWidth: 2,
	currentPositionRadius: 3,

	appearance: {
		stroke: '#FFFFFF',
		strokeOpacity: 0.2,
		strokeWidth: 1,
		fontFamily: "'Roboto', sans-serif",
		fontSize: 12,
		fontFill: '#219fda',
		edgeStroke: "#219fda",
		edgeFill: "#FFFFFF00",
		nsEdgeFill: "#219fda",
		edgeStrokeWidth: 1,
		r: 3,
	}
};

export const trendStyle = {
	currentPositionStroke: "#219fda",
	currentPositionStrokeWidth: 2,
	currentPositionRadius: 3,

	appearance: {
		stroke: "#FFFFFF",
		strokeOpacity: 0.5,
		strokeWidth: 1,
		strokeDasharray: "Solid",
		edgeStrokeWidth: 1,
		edgeFill: "#FFFFFF00",
		edgeStroke: "#219fda",
		r: 3,
	}
};

export const eqdsStyle = {
	currentPositionStroke: "#219fda",
	currentPositionStrokeWidth: 2,
	currentPositionRadius: 3,

	appearance: {
		stroke: '#FFFFFF',
		strokeOpacity: 0.2,
		strokeWidth: 1,
		fill: "#FFFFFF",
		fillOpacity: 0.4,
		edgeStroke: "#219fda",
		edgeFill: "#FFFFFF00",
		edgeFill2: "#219fda",
		edgeStrokeWidth: 1,
		r: 3,
	}
};

export const stdevStyle = {
	currentPositionStroke: "#219fda",
	currentPositionStrokeWidth: 2,
	currentPositionRadius: 3,

	appearance: {
		stroke: '#219fda',
		strokeOpacity: 1,
		strokeWidth: 1,
		fill: "#FFFFFF",
		fillOpacity: 0.4,
		edgeStrokeWidth: 2,
		edgeStroke: "#219fda",
		edgeFill: "#FFFFFF00",
		r: 3,
	},

};

export const exchangeColors = [
	'#cc0066',
	'#0066cc',
	'#aaff00',
	'#6600cc',
	'#cc401d',
	'#6ddba5',
	'#ffc400',
	'#b21dcc'
];

export const ganfanStyle = {
	currentPositionStroke: "#219fda",
	currentPositionStrokeWidth: 2,
	currentPositionRadius: 3,

	appearance: {
		stroke: '#FFFFFF',
		strokeOpacity: 0.2,
		strokeWidth: 1,

		edgeStroke: "#219fda",
		edgeFill: "#FFFFFF00",
		edgeStrokeWidth: 1,
		r: 3,
		fill: ["#e41a1c", "#377eb8", "#4daf4a", "#984ea3", "#ff7f00", "#ffff33", "#a65628", "#f781bf"],
		fillOpacity: 0.2,
		fontFamily: "'Roboto', sans-serif",
		fontSize: 12,
		fontFill: "#219fda"
	}
};