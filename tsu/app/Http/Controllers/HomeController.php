<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use \App\Location;
use \App\Item;
use \App\User;
use \App\Form;
use \App\Eqpt;
use \App\Abnormal;

class HomeController extends Controller {
	public function __construct() {
		$this -> middleware('auth');
	}

	public function index() {
		$nts = Abnormal::where('created_time', '>=', Carbon::now() -> subDay(2)) -> orderBy('created_time', 'desc') -> get();
		$location_cnt = Location::all() -> count();
		$item_cnt = Item::all() -> count();
		$user_cnt = User::all() -> count();
		$form_cnt = Form::all() -> count();

		$url = "http://www.cwb.gov.tw/V7/forecast/taiwan/inc/city/Taipei_City.htm"; 
		$post = array();
		$ch = curl_init();
		$options = array(
			CURLOPT_REFERER => '',
			CURLOPT_URL => $url,
			CURLOPT_VERBOSE => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($post),
		);

		curl_setopt_array($ch, $options);

		$result = curl_exec($ch);

		curl_close($ch);
		preg_match_all('/<table class="FcstBoxTable01" [^>]*[^>]*>(.*)<\/div>/si', $result, $matches, PREG_SET_ORDER);
		preg_match_all('/<td nowrap="nowrap" [^>]*[^>]*>(.*)<\/td>/si', $matches[0][1], $m1, PREG_SET_ORDER);

		$m2 = explode('</td>', $m1[0][1]);
		$weather = array();

		for ($i = 0; $i <= 6; $i++) {
			preg_match_all('/src=[^>]*[^>](.*)/si',$m2[$i], $m5, PREG_SET_ORDER);
			$m6 = explode('"',$m5[0][0]);
			$wi='http://www.cwb.gov.tw/V7/'.trim($m6[1],'\.\./\.\./');
			$wtitle = $m6[3];
			$weather[$i]['date'] = date("m/d", mktime(0, 0, 0, date("m"), date("d") + $i, date("Y")));
			$weather[$i]['temperature'] = trim(strip_tags($m2[$i])); 
			$weather[$i]['title'] = $wtitle;
			$weather[$i]['img'] = $wi;
		}
		
		return view('home', ['nts'=> $nts, 'location_cnt'=> $location_cnt, 'item_cnt'=> $item_cnt, 'user_cnt'=> $user_cnt, 'form_cnt'=> $form_cnt, 'weather'=> $weather]);
	}
}
