import {delay} from 'redux-saga';
import {put, call, take, race, fork, all, select} from 'redux-saga/effects';
import {POLL_DATA_STOP, SET_INTERVAL} from "../constants/ChartActionTypes";
import {pollInterval} from "../constants/ChartSettings";
import {pollData as pollDataAction} from '../actions/ChartActions';

const dataFetchParams = (state) => [state.market_data.market, state.market_data.interval, state.market_data.last_updated];

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
		]);
	}
}

export default function* root() {
	yield all([
		fork(watchPollData)
	]);
}
