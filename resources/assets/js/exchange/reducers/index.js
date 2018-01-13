import {combineReducers} from 'redux';
import OrderHistoryReducer from './reducer-order-history';
import OpenOrdersReducer from './reducer-open-orders';
import ChartingReducer from './reducer-charting';
import MarketDataReducer from './reducer-market-data';

const allReducers = combineReducers({
	order_history: OrderHistoryReducer,
	open_orders: OpenOrdersReducer,
	charting: ChartingReducer,
	market_data: MarketDataReducer,
});

export default allReducers;