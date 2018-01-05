import {combineReducers} from 'redux';
import OrderHistoryReducer from './reducer-order-history';
import OpenOrdersReducer from './reducer-open-orders';
import ChartReducer from './reducer-chart';

const allReducers = combineReducers({
	order_history: OrderHistoryReducer,
	open_orders: OpenOrdersReducer,
	chart: ChartReducer,
});

export default allReducers;