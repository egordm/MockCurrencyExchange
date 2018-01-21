import {CREATE_ORDER_FAIL, HIDE_MESSAGE} from "../constants/ChartActionTypes";
import React from "react";

const initialState = {
	title: null,
	message: null
};

function prefabMessages(code, action) {
	switch (code) {
		case 401:
			return {title: 'Unauthorized', message: 'You are not logged in to do that.'};
		case 400:
			const messageData = action.error.response.data.message;
			const message = messageData instanceof Object ? Object.values(messageData).map((el, i) => <p key={i}>{el}</p>) : messageData;
			return {title: 'Validation errors', message: <div className="text-center">{message}</div>};
		default:
			return null;
	}
}

export default function (state = initialState, action) {
	switch (action.type) {
		case CREATE_ORDER_FAIL:
			const status = action.error.response.status;
			return prefabMessages(status, action);
		case HIDE_MESSAGE:
			return initialState;
		default:
			return state
	}
}

