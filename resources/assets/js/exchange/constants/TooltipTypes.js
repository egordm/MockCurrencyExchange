import {MovingAverageTooltip, SingleValueTooltip, BollingerBandTooltip} from "react-stockcharts/es/lib/tooltip";

export const MATT = {value: "MATT", element: MovingAverageTooltip};
export const SINGLEVALUE = {value: "SINGLEVALUE", element: SingleValueTooltip};
export const BOLLTT = {value: "BOLLTT", element: BollingerBandTooltip};

export function tooltipHeight(type) {
	switch (type.value) {
		case MATT.value: {
			return 46;
		}
		default: return 22;
	}
}