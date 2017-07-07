<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;

use \App\Abnormal;
use \App\Item;
use \App\ItemDetail;
use \App\Location;
use \App\Form;
use \App\Eqpt;

class EqptController extends Controller {
	public function __construct() {
		$this -> middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$items = ItemDetail::all();

		return view('eqpt', ['nts'=> $nts, 'items' => $items]);
	}

	public function eqptDetail($id) {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$item = ItemDetail::find($id);
		$form = Form::where('item_detail_id', $id) -> orderBy('created_time', 'desc') -> first();

		return view('eqpt_detail', ['nts'=> $nts, 'item' => $item, 'form' => $form]);
	}

	public function viewEqpt(Request $request) {
		if ($request -> ajax()) {
			$eqpt = Eqpt::find($request -> id);

			return response() -> json($eqpt);
		}
	}

	public function createEqpt(Request $request) {
		$eqpt = new Eqpt;
		$eqpt -> form_id = $request -> form_id;
		$eqpt -> fill($request -> all());
		$eqpt -> check_quantity = $request -> quantity;
		$eqpt -> save();

		return back() -> with('success', '新增成功！');
	}

	public function updateEqpt(Request $request) {
		$eqpt = Eqpt::find($request -> id);
		$eqpt -> fill($request->all());
		$eqpt -> check_quantity = $request -> quantity;
		$eqpt -> save();

		return back() -> with('success', '修改成功！');
	}

	public function removeEqpt(Request $request) {
		$eqpt = Eqpt::find($request -> id);
		$response = $eqpt -> delete();

		return back() -> with('success', '刪除成功！');
	}
}