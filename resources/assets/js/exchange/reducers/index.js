import {combineReducers} from 'redux';
import OrderHistoryReducer from './reducer-order-history';
import OpenOrdersReducer from './reducer-open-orders';
import ChartingReducer from './reducer-charting';

const allReducers = combineReducers({
	order_history: OrderHistoryReducer,
	open_orders: OpenOrdersReducer,
	charting: ChartingReducer,
});

export default allReducers;