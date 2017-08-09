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

class ItemController extends Controller {
	public function __construct() {
		$this -> middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$items = Item::all();

		return view('item', ['nts'=> $nts, 'items' => $items]);
	}

	public function viewItem(Request $request) {
		if ($request -> ajax()) {
			$item = Item::find($request -> id);

			return response() -> json($item);
		}
	}

	public function createItem(Request $request) {
		$name = Item::where('name', $request -> name) -> get();

		if ($name != '[]') {
			return back() -> with('warning', '新增失敗！');
		} else {
			$item = new Item;
			$item -> fill($request -> all());
			$item -> created_time = Carbon::now() -> format('Y-m-d H:i:s');
			$item -> save();

			return back() -> with('success', '新增成功！');
		}
	}

	public function updateItem(Request $request) {
		$name = Item::where('name', $request -> name) -> get();

		if ($name != '[]') {
			return back() -> with('warning', '修改失敗！');
		} else {
			$item = Item::find($request -> id);
			$item -> fill($request -> all());
			$item -> updated_time = Carbon::now() -> format('Y-m-d H:i:s');
			$item -> save();

			return back() -> with('success', '修改成功！');
		}
	}

	public function removeItem(Request $request) {
		$item = Item::find($request -> id);
		$response = $item -> delete();

		return back() -> with('success', '刪除成功！');
	}

	public function itemDetail($id) {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$items = Item::find($id);
		$locations = Location::all();

		return view('item_detail', ['nts'=> $nts, 'items' => $items, 'locations' => $locations]);
	}
	
	public function viewItemDetail(Request $request) {
		if ($request -> ajax()) {
			$item = ItemDetail::with('location') -> where('item_id', $request -> item_id) -> where('location_id', $request -> location_id) -> firstOrFail();

			return response() -> json($item);
		}
	}

	public function createItemDetail(Request $request) {
		$location = ItemDetail::where('item_id', $request -> item_id) -> where('location_id', $request -> location_id) -> get();

		if ($location != '[]') {
			return back() -> with('warning', '新增失敗！');
		} else {
			$item = new ItemDetail;
			$item -> fill($request -> all());
			$item -> created_time = Carbon::now() -> format('Y-m-d H:i:s');
			$item -> save();

			$abbr = ItemDetail::find($item -> id) -> abbr;
			$today = Carbon::now() -> toDateString();
			$form_id = $abbr.$today;
			$form = new Form;
			$form -> form_id = $form_id;
			$form -> item_detail_id = $item -> id;
			$form -> user_id = $request -> user_id;
			$form -> created_time = Carbon::now() -> format('Y-m-d H:i:s');
			$form -> save();

			return back() -> with('success', '新增成功！');
		}
	}

	public function updateItemDetail(Request $request) {
		$location = ItemDetail::where('item_id', $request -> item_id) -> where('location_id', $request -> location_id) -> get();

		if ($location != '[]') {
			return back() -> with('warning', '修改失敗！');
		} else {
			$item = ItemDetail::find($request -> id);
			if ($request -> location_id != "") {
				$item -> fill($request -> all());
			} else {
				$item -> abbr = $request -> abbr;
			}
			$item -> updated_time = Carbon::now() -> format('Y-m-d H:i:s');
			$item -> save();

			return back() -> with('success', '修改成功！');
		}
	}

	public function removeItemDetail(Request $request) {
		$item = ItemDetail::find($request -> id);
		$item -> status = 0;
		$item -> save();

		return back() -> with('success', '註銷成功！');
	}

	public function applyItemDetail(Request $request) {
		$item = ItemDetail::find($request -> id);
		$item -> status = 1;
		$item -> save();

		return back() -> with('success', '登記成功！');
	}
}
