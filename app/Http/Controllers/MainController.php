<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 1-12-2017
 * Time: 21:15
 */

namespace App\Http\Controllers;


class MainController extends Controller
{
	public function index() {
		return view('index');
	}

	public function exchange() {
		return view('exchange');
	}
}