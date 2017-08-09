<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Hash;

use \App\Abnormal;
use \App\User;
use \App\CheckLog;
use \App\ItemDetail;

class UserController extends Controller {
	public function __construct() {
		$this -> middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$users = User::all();

		return view('user', ['nts'=> $nts, 'users' => $users]);
	}

	public function viewUser(Request $request) {
		if ($request -> ajax()) {
			$user = User::find($request -> id);

			return response() -> json($user);
		}
	}

	public function createUser(Request $request) {
		$user = new User;
		$user -> name = $request -> name;
		$user -> username = $request -> username;
		$user -> password = bcrypt($request -> password);
		$user -> email = $request -> email;
		$user -> tel = $request -> tel;
		$user -> save();

		return back() -> with('success', '新增成功！');
	}

	public function createAdmin(Request $request) {
		$user = new User;
		$user -> name = $request -> name;
		$user -> username = $request -> username;
		$user -> password = bcrypt($request -> password);
		$user -> email = $request -> email;
		$user -> tel = $request -> tel;
		$user -> level = 1;
		$user -> save();

		return back() -> with('success', '新增成功！');
	}

	public function updateUser(Request $request) {
		$user = User::find($request -> id);
		$user -> fill($request -> all());
		$user -> save();

		return back() -> with('success', '修改成功！');
	}

	public function updatePassword(Request $request) {
		$user = User::find($request -> id);

		if (!Hash::check($request -> old_password, $user -> password)) {
			return back() -> with('warning', '密碼錯誤！');
		} else {
			$user -> password =  bcrypt($request -> new_password);
			$user -> save();
			return back() -> with('success', '修改成功！');
		}
	}

	public function removeUser(Request $request) {
		$user = User::find($request -> id);
		$user -> status = 0;
		$user -> save();

		return back() -> with('success', '註銷成功！');
	}

	public function applyUser(Request $request) {
		$user = User::find($request -> id);
		$user -> status = 1;
		$user -> save();

		return back() -> with('success', '登記成功！');
	}

	public function checkLog() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$logs = CheckLog::orderBy('id', 'desc')->get();

		return view('check_log', ['nts'=> $nts, 'logs' => $logs]);
	}
	
	public function viewLog(Request $request) {
		if ($request -> ajax()) {
			$item_detail = ItemDetail::with('item', 'location') -> where('id', $request -> item_detail_id) -> firstOrFail();
			$log = CheckLog::with('user') -> where('id', $request -> id) -> firstOrFail();

			return response() -> json(['item_detail' => $item_detail, 'log' => $log]);
		}
	}

	public function updateLog(Request $request) {
		$log = CheckLog::find($request -> id);
		$check_in_time = Carbon::parse($request -> check_in_time);
		$preiod = round($check_in_time -> diffInMinutes(Carbon::parse($request -> check_out_time)) / 60, 1);
		$log -> check_in_time = $request -> check_in_time;
		$log -> check_out_time = $request -> check_out_time;
		$log -> period = $preiod;
		$log -> extra = 0;
		$log -> save();
		$acc_period = CheckLog::where('user_id', $log -> user_id) -> whereDate('check_in_time', $check_in_time -> toDateString()) -> get() -> sum('period');

		if ($acc_period > 8) {
			$log -> period = $preiod  - $acc_period + 8;
			$log -> extra = $acc_period - 8;
			$log -> save();
		}

		return back() -> with('success', '修改成功！');
	}
}
