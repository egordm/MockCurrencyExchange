import {delay} from 'redux-saga';
import {put, call, take, race, fork, all, select} from 'redux-saga/effects';
import {POLL_DATA_STOP, SET_INTERVAL, SET_MARKET} from "../constants/ChartActionTypes";
import {pollInterval} from "../constants/ChartSettings";
import {pollData as pollDataAction} from '../actions/DataActions';

const dataFetchParams = (state) => [state.market_data.market, state.market_data.interval, state.market_data.last_polled];

function* pollData() {
	const params = yield select(dataFetchParams);
	yield put(pollDataAction(...params));
	yield delay(pollInterval);
}

function* watchPollData() {
	while (true) {
		yield race([
			call(pollData),
			take(POLL_DATA_STOP),
			take(SET_INTERVAL),
			take(SET_MARKET)
		]);
	}
}

export default function* root() {
	yield all([
		fork(watchPollData)
	]);
}
