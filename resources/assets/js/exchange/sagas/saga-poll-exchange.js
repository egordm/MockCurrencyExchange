import {delay} from 'redux-saga';
import {put, call, take, race, fork, all, select} from 'redux-saga/effects';
import {POLL_DATA_STOP} from "../constants/ChartActionTypes";
import {pollInterval} from "../constants/ChartSettings";
import {pollData as pollDataAction} from '../actions/ChartActions';

const dataFetchParams = (state) => [state.charting.market, state.charting.interval, state.charting.last_updated];

function* pollData() {
	yield delay(pollInterval);
	const params = yield select(dataFetchParams);
	yield put(pollDataAction(...params));
}

function* watchPollData() {
	while (true) {
		yield race([
			call(pollData),
			take(POLL_DATA_STOP)
		]);
	}
}

export default function* root() {
	yield all([
		fork(watchPollData)
	]);
}
