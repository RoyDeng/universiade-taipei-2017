<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;

use \App\User;
use \App\ItemDetail;
use \App\CheckLog;
use \App\Note;
use \App\Form;
use \App\Eqpt;
use \App\Abnormal;

class DBController extends Controller {
	public function Login(Request $request) {
		if (Auth::attempt(array(
			'username' => $request -> username,
			'password' => $request -> password
		))) {
			$user = User::where('username', $request -> username) -> firstOrFail();
			$status = $user -> status;
			if ($status == 0) {
				return 'fail';
			} else {
				$username = $user -> username;
				$period = time() + 3600 * 24 * 3;
				$key = str_random(40);
				$user -> token = substr(md5($username.$key.$period), -8).$period;
				$user -> save();
				$check_log = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first();
				$form = Form::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first();
				$is_check_in = false;
				$check = false;
				$is_check_out = false;
				$is_check_eqpt = false;

				if ($check_log != null) {
					$item_detail_id = $check_log -> item_detail_id;

					if (substr($check_log -> check_in_time, 0, 10) == date('Y-m-d')) {
						$check = ItemDetail::with('item', 'location') -> where('id', $item_detail_id) -> get();
						$is_check_in = true;
					}

					if (substr($check_log -> check_out_time, 0, 10) == date('Y-m-d')) {
						$is_check_out = true;
					}
				}

				if ($form != null) {
					if (substr($form -> created_time, 0, 10) == date('Y-m-d')) {
						$is_check_eqpt = true;
					}
				}

				return json_encode(['user' => $user, 'is_check_in' => $is_check_in, 'check' => $check, 'is_check_out' => $is_check_out, 'is_check_eqpt' => $is_check_eqpt], JSON_UNESCAPED_UNICODE);
			}
		} else {
			return 'fail';
		}
	}

	public function LoadData(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$data = ItemDetail::with('item', 'location') -> where('status', 1) -> get();

			return json_encode($data, JSON_UNESCAPED_UNICODE);
		}
	}

	public function CheckIn(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$item = ItemDetail::where('id', $request -> item_detail_id) -> firstOrFail();
			$msg = Note::where('item_detail_id', 71) -> get();
			$notes = Note::where('item_detail_id', $request -> item_detail_id) -> get();
			$check_log = new CheckLog;
			$check_log -> user_id = $user -> id;
			$check_log -> item_detail_id = $request -> item_detail_id;
			$check_log -> check_in_time = Carbon::now() -> format('Y-m-d H:i:s');
			$check_log -> save();

			return json_encode(['item' => $item -> item -> name, 'location' => $item -> location -> name, 'msg' => $msg, 'notes' => $notes], JSON_UNESCAPED_UNICODE);
		}
	}

	public function CheckOut(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$check_log = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first();
			$msg = Note::where('item_detail_id', 71) -> get();
			$notes = Note::where('item_detail_id', $check_log -> item_detail_id) -> get();
			$check_in_time = Carbon::parse($check_log -> check_in_time);
			$preiod = round($check_in_time -> diffInMinutes(Carbon::now()) / 60, 1);
			$check_log -> check_out_time = Carbon::now() -> format('Y-m-d H:i:s');
			$check_log -> period = $preiod;
			$check_log -> extra = 0;
			$check_log -> save();
			$acc_period = CheckLog::where('user_id', $user -> id) -> whereDate('check_in_time', $check_in_time -> toDateString()) -> get() -> sum('period');

			if ($acc_period > 8) {
				$check_log -> period = $preiod  - $acc_period + 8;
				$check_log -> extra = $acc_period - 8;
				$check_log -> save();
			}

			return json_encode(['msg' => $msg, 'notes' => $notes], JSON_UNESCAPED_UNICODE);
		}
	}

	public function EquipCheckLoad(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$item_detail_id = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first() -> item_detail_id;
			$form = Form::with('eqpt') -> where('item_detail_id', $item_detail_id) -> orderBy('created_time', 'desc') -> first();
			$check_log = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first();
			$last_form = Form::where('user_id', $user -> id) -> where('item_detail_id', $check_log -> item_detail_id) -> orderBy('id', 'desc') -> first();
			$is_check_eqpt = false;

			if ($last_form != null) {
				if (substr($last_form -> created_time, 0, 10) == date('Y-m-d')) {
					$is_check_eqpt = true;
				}
			}

			return json_encode(['form' => $form, 'is_check_eqpt' => $is_check_eqpt], JSON_UNESCAPED_UNICODE);
		}
	}

	public function EquipCheck(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$item_detail_id = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first() -> item_detail_id;
			$abbr = ItemDetail::find($item_detail_id) -> abbr;
			$today = Carbon::now() -> toDateString();
			$form_id = $abbr.$today;
			$new_form = new Form;
			$new_form -> form_id = $form_id;
			$new_form -> item_detail_id = $item_detail_id;
			$new_form -> user_id = User::where('username', $request -> username) -> firstOrFail() -> id;
			$new_form -> created_time = Carbon::now() -> format('Y-m-d H:i:s');
			$new_form -> save();
			$form = Form::where('item_detail_id', $item_detail_id) -> orderBy('created_time', 'desc') -> first();

			if ($form -> eqpt == '[]') {
				$eqpts = json_decode(json_encode($request -> eqpt), true);
				$sql = array();

				foreach ($eqpts as $eqpt) {
					$sql[] = array(
						'form_id' => $form -> id,
						'name' => $eqpt['name'],
						'unit' => $eqpt['unit'],
						'quantity' => $eqpt['quantity'],
						'check_quantity' => $eqpt['check_quantity']
					);
				}

				DB::table('eqpt') -> insert($sql);
			}

			return json_encode(['sql' => $sql], JSON_UNESCAPED_UNICODE);
		}
	}

	public function ReportLoad(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$item_detail_id = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first() -> item_detail_id;
			$form_id = Form::where('item_detail_id', $item_detail_id) -> orderBy('created_time', 'desc') -> first() -> id;
			//$eqpt = DB::table('eqpt') -> where('form_id', $form_id) -> where('quantity', '>', DB::raw('check_quantity')) -> get();
			$form = Form::with('eqpt') -> where('item_detail_id', $item_detail_id) -> orderBy('created_time', 'desc') -> first();

			return json_encode($form, JSON_UNESCAPED_UNICODE);
		}
	}

	public function ReportPage($eqpt_id, $form_id, $username, $token) {
		$user = User::where('username', $username) -> firstOrFail();

		if ($token == $user -> token) {
			return view('report', ['eqpt_id'=> $eqpt_id, 'form_id' => $form_id, 'username'=> $username, 'token'=> $token]);
		}
	}

	public function Report(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$item_detail_id = CheckLog::where('user_id', $user -> id) -> orderBy('id', 'desc') -> first() -> item_detail_id;
			$form = Form::with('eqpt') -> where('item_detail_id', $item_detail_id) -> orderBy('created_time', 'desc') -> first();
			$abns = json_decode(json_encode($request -> abn), true);
			$sql = array();

			foreach ($abns as $abn) {
				$eqpt = Eqpt::find($abn['eqpt_id']);
				if ($eqpt -> abnormal == '[]') {
					$sql[] = array(
						'eqpt_id' => $abn['eqpt_id'],
						'form_id' => $form -> id,
						'quantity' => $abn['quantity'],
						'remark' => $abn['remark'],
						'pic' => $abn['pic'],
						'report' => $abn['report'],
						'created_time' => Carbon::now() -> format('Y-m-d H:i:s')
					);
				} else {
					$sql[] = null;
				}
			}

			DB::table('abnormal') -> insert($sql);

			return 'success';
		}
	}

	public function Sign(Request $request) {
			$user = User::where('username', $request -> username) -> firstOrFail();

			if ($request -> token == $user -> token) {
				$abn = Abnormal::where('eqpt_id', $request -> eqpt_id) -> where('form_id', $request -> form_id) -> firstOrFail();
				$abn -> signature = $request -> signature;
				$abn -> save();

				return back() -> with('success', '簽章成功！');
			}
	}

	public function Logout(Request $request) {
		$user = User::where('username', $request -> username) -> firstOrFail();

		if ($request -> token == $user -> token) {
			$user -> token = str_random(18);
			$user -> save();
			Auth::logout();
			return 'success';
		}
	}
}
