import {delay} from 'redux-saga';
import {put, call, take, race, fork, all, select} from 'redux-saga/effects';
import {LOGIN_SUCCESS, CREATE_ORDER_SUCCESS, LOGOUT_SUCCESS} from "../constants/ChartActionTypes";
import {userPollInterval} from "../constants/ChartSettings";
import {pollUserData as pollDataAction} from '../actions/DataActions';

const dataFetchParams = (state) => [state.user_data.last_polled];
const isLoggedIn = (state) => state.user_data.logged_in;

function* pollData() {
	const params = yield select(dataFetchParams);
	yield put(pollDataAction(...params));
	yield delay(userPollInterval);
}

function* watchPollData() {
	while (true) {
		yield race([
			call(pollData),
			take(CREATE_ORDER_SUCCESS),
			take(LOGOUT_SUCCESS),
			take(LOGIN_SUCCESS),
		]);
		const logged_in = yield select(isLoggedIn);
		if(!logged_in) take(LOGIN_SUCCESS);
	}
}

export default function* root() {
	yield all([
		fork(watchPollData)
	]);
}
