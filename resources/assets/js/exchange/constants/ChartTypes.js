import {AreaSeries, LineSeries, CandlestickSeries, RenkoSeries, KagiSeries, PointAndFigureSeries} from "react-stockcharts/es/lib/series";

export const AREA = { label: "Area", value: "AREA"};
export const LINE = { label: "Line", value: "LINE"};
export const CANDLESTICK = { label: "Candlestick", value: "CANDLESTICK"};
export const HEIKIN_ASHI = { label: "Heikin Ashi", value: "HEIKIN_ASHI"};
export const RENKO = { label: "Renko", value: "RENKO"};
export const KAGI = { label: "Kagi", value: "KAGI"};
export const POINT_FIGURE = { label: "Point & Figure", value: "POINT_FIGURE"};

export function chartFromType(type) {
	switch (type.value) {
		case AREA.value: {
			return AreaSeries;
		}
		case LINE.value: {
			return LineSeries;
		}
		case CANDLESTICK.value: {
			return CandlestickSeries;
		}
		case HEIKIN_ASHI.value: {
			return CandlestickSeries;
		}
		case RENKO.value: {
			return RenkoSeries;
		}
		case KAGI.value: {
			return KagiSeries;
		}
		case POINT_FIGURE.value: {
			return PointAndFigureSeries;
		}
	}
}