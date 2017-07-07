<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;

use \App\Abnormal;
use \App\ItemDetail;
use \App\Note;

class NoteController extends Controller {
	public function __construct() {
		$this -> middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$items = ItemDetail::all();

		return view('note', ['nts'=> $nts, 'items' => $items]);
	}

	public function noteDetail($id) {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$item = ItemDetail::find($id);
		$notes = Note::where('item_detail_id', $id) -> get();

		return view('note_detail', ['nts'=> $nts, 'item' => $item, 'notes' => $notes]);
	}

	public function viewNote(Request $request) {
		if ($request -> ajax()) {
			$note = Note::find($request -> id);

			return response() -> json($note);
		}
	}

	public function createNote(Request $request) {
		$note = new Note;
		$note -> fill($request -> all());
		$note -> created_time = Carbon::now() -> format('Y-m-d H:i:s');
		$note -> save();

		return back() -> with('success', '新增成功！');
	}

	public function updateNote(Request $request) {
		$note = Note::find($request -> id);
		$note -> fill($request -> all());
		$note -> updated_time = Carbon::now() -> format('Y-m-d H:i:s');
		$note -> save();

		return back() -> with('success', '修改成功！');
	}

	public function removeNotification(Request $request) {
		$notification = Notification::find($request -> id);
		$response = $notification -> delete();

		return back() -> with('success', '刪除成功！');
	}
}
