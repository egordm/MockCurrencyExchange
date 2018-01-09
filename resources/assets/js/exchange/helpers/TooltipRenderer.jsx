import React from "react";
import {styleFromTooltipType} from "../constants/ChartStyles";
import {tooltipHeight} from "../constants/TooltipTypes";

export function renderMultiple(tooltips, offset=0) {
	let ret = [];
	for(const tooltip of Object.values(tooltips)) {
		ret.push(renderTooltip(tooltip, offset));
		offset += tooltipHeight(tooltip.type);
	}
	return ret;
}

export function renderTooltip(tooltip, offset) {
	const TooltipType = tooltip.type.element;
	const style = styleFromTooltipType(tooltip.type);
	if(tooltip.options && tooltip.options.length > 0) {
		return <TooltipType key={'tooltip-' + tooltip.type.value} options={tooltip.options} {...style} {...tooltip.properties} origin={[0, offset]}/>
	} else {
		return <TooltipType key={'tooltip-' + tooltip.type.value} {...style} {...tooltip.properties} origin={[0, offset]}/>
	}
}