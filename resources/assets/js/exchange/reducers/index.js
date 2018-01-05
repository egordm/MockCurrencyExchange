import {combineReducers} from 'redux';
import OrderHistoryReducer from './reducer-order-history';
import OpenOrdersReducer from './reducer-open-orders';

const allReducers = combineReducers({
	order_history: OrderHistoryReducer,
	open_orders: OpenOrdersReducer
});

export default allReducers;