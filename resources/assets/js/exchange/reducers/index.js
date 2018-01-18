import {combineReducers} from 'redux';
import UserDataReducer from './reducer-user-data';
import ChartingReducer from './reducer-charting';
import MarketDataReducer from './reducer-market-data';

const allReducers = combineReducers({
	charting: ChartingReducer,
	market_data: MarketDataReducer,
	user_data: UserDataReducer,
});

export default allReducers;