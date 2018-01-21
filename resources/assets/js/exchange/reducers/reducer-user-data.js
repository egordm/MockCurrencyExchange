import {
	CANCEL_ORDER_SUCCESS, CREATE_ORDER_FAIL, CREATE_ORDER_SUCCESS, GET_BALANCE_SUCCESS, GET_ORDERS_SUCCESS, LOGIN_FAIL, LOGIN_SUCCESS, LOGOUT_SUCCESS, POLL_USER_DATA_FAIL,
	POLL_USER_DATA_SUCCESS,
	USER_SUCCESS
} from "../constants/ChartActionTypes";
import update from 'react-addons-update';
import {mergeBalance, mergeOrders} from "../utils/DataProcessing";

const initialState = {
	last_polled: null,
	logged_in: false,

	// Global Data
	balance: null,
	orders: null,
};

export default function (state = initialState, action) {
	if([POLL_USER_DATA_FAIL, LOGIN_FAIL, CREATE_ORDER_FAIL].includes(action.type) && action.error.response.status === 401) {
		return {...state, logged_in: false};
	}

	switch(action.type) {
		case LOGIN_SUCCESS:
			return {...state, logged_in: true};
		case USER_SUCCESS:
			return {...state, logged_in: true};
		case LOGOUT_SUCCESS:
			return {...state, logged_in: false, balance: [], orders: []};
		case GET_BALANCE_SUCCESS:
			return {...state, balance: mergeBalance(state.balance, action.payload.data.data)};
		case GET_ORDERS_SUCCESS:
			return {...state, orders: mergeOrders(state.orders, action.payload.data.data)};
		case CREATE_ORDER_SUCCESS:
			return update(state, {
				orders: {$merge: {[action.payload.data.data.id]: action.payload.data.data}}
			});
		case CANCEL_ORDER_SUCCESS:
			return update(state, {
				orders: {$merge: {[action.payload.data.data.id]: action.payload.data.data}}
			});
		case POLL_USER_DATA_SUCCESS:
			return {
				...state,
				balance: mergeBalance(state.balance, action.payload.data.data.balance),
				orders: mergeOrders(state.orders, action.payload.data.data.orders)
			};
		default:
			return state;
	}
}