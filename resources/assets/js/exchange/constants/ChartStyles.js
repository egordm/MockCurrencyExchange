import {AREA, CANDLESTICK, HEIKIN_ASHI, KAGI, LINE, POINT_FIGURE, RENKO} from "./ChartTypes";

export const chartMargin = {left: 0, right: 50, top: 0, bottom: 30};

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
		default: return {};
	}
}