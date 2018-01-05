import {CHART_RESIZE} from "../constants/ChartActionTypes";

const initialState = {
	width: 100,
	height: 100
};

export default function (state = initialState, action) {
	switch (action.type) {
		case CHART_RESIZE:
			let {width, height} = action.payload;
			return {...state, width, height};
		default:
			return state;
	}
}