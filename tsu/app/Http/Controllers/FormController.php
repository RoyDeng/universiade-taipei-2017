<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;

use \App\Abnormal;
use \App\ItemDetail;
use \App\Form;
use \App\Eqpt;

class FormController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$forms = Form::orderBy('created_time', 'desc') -> get();

		return view('form', ['nts'=> $nts, 'forms' => $forms]);
	}

	public function formDetail($id) {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$form = Form::find($id);
		$eqpts = Eqpt::where('form_id', $id) -> get();
		$abns = Abnormal::where('form_id', $id) -> get();

		return view('form_detail', ['nts'=> $nts, 'form'=> $form, 'eqpts' => $eqpts, 'abns' => $abns]);
	}
}
