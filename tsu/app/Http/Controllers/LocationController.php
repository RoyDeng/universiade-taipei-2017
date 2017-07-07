<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;

use \App\Abnormal;
use \App\Location;

class LocationController extends Controller {
	public function __construct() {
		$this -> middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$locations = Location::all();

		return view('location', ['nts'=> $nts, 'locations' => $locations]);
	}

	public function viewLocation(Request $request) {
		if ($request -> ajax()) {
			$location = Location::find($request -> id);

			return response() -> json($location);
		}
	}

	public function createLocation(Request $request) {
		$name = Location::where('name', $request -> name) -> get();

		if ($name != '[]') {
			return back() -> with('warning', '新增失敗！');
		} else {
			$location = new Location;
			$location -> fill($request -> all());
			$location -> created_time = Carbon::now() -> format('Y-m-d H:i:s');
			$location -> save();

			return back() -> with('success', '新增成功！');
		}
	}

	public function updateLocation(Request $request) {
		$location = Location::find($request -> id);
		$location -> fill($request -> all());
		$location -> updated_time = Carbon::now() -> format('Y-m-d H:i:s');
		$location -> save();

		return back() -> with('success', '修改成功！');
	}

	public function removeLocation(Request $request) {
		$location = Location::find($request -> id);
		$response = $location -> delete();

		return back() -> with('success', '刪除成功！');
	}
}
