@extends('layouts.master')

@section('title','後台管理系統-泰達運動顧問有限公司')

@section('content')
<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">首頁</h1>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-xs-12 col-sm-8">
				 <div class="col-xs-12 col-sm-6 col-lg-6">
					<div class="tile-counter bg-primary">
						<div class="content">
							<i class='fa fa-building icon-lg'></i>
							<h2 class="number_counter" data-speed="3000" data-from="0" data-to="{{ $location_cnt }}">{{ $location_cnt }}</h2>
							<div class="clearfix"></div>
							<span>場館</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<div class="tile-counter bg-accent">
						<div class="content">
							<i class='fa fa-bicycle icon-lg'></i>
							<h2 class="number_counter" data-speed="3000" data-from="0" data-to="{{ $item_cnt }}">{{ $item_cnt }}</h2>
							<div class="clearfix"></div>
							<span>項目</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<div class="tile-counter bg-purple">
						<div class="content">
							<i class='fa fa-users icon-lg'></i>
							<h2 class="number_counter" data-speed="3000" data-from="0" data-to="{{ $user_cnt }}">{{ $user_cnt }}</h2>
							<div class="clearfix"></div>
							<span>工作人員</span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<div class="tile-counter bg-success">
						<div class="content">
							<i class='fa fa-file-excel-o icon-lg'></i>
							<h2 class="number_counter" data-speed="3000" data-from="0" data-to="{{ $form_cnt }}">{{ $form_cnt }}</h2>
							<div class="clearfix"></div>
							<span>驗收單</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="r3_weather">
					<div class="wid-weather wid-weather-small">
						<div>
							<div class="location">
								<h3>臺北市</h3>
								<span>{{ $weather[0]["date"] }}</span>
								<img src="{{ $weather[0]['img'] }}" title="{{ $weather[0]['title'] }}">
							</div>
							<div class="clearfix"></div>
							<div class="degree">
								<h3>{{ $weather[0]["temperature"] }}°C</h3>
							</div>
							<div class="clearfix"></div>
							<div class="weekdays bg-white">
								<ul class="list-unstyled">
									<li><span class="day">{{ $weather[1]["date"] }}</span><img src="{{ $weather[1]['img'] }}" title="{{ $weather[1]['title'] }}"><span class="temp">{{ $weather[1]["temperature"] }}°C</span></li>
									<li><span class="day">{{ $weather[2]["date"] }}</span><img src="{{ $weather[2]['img'] }}" title="{{ $weather[2]['title'] }}"><span class="temp">{{ $weather[2]["temperature"] }}°C</span></li>
									<li><span class="day">{{ $weather[3]["date"] }}</span><img src="{{ $weather[3]['img'] }}" title="{{ $weather[3]['title'] }}"><span class="temp">{{ $weather[3]["temperature"] }}°C</span></li>
									<li><span class="day">{{ $weather[4]["date"] }}</span><img src="{{ $weather[4]['img'] }}" title="{{ $weather[4]['title'] }}"><span class="temp">{{ $weather[4]["temperature"] }}°C</span></li>
									<li><span class="day">{{ $weather[5]["date"] }}</span><img src="{{ $weather[5]['img'] }}" title="{{ $weather[5]['title'] }}"><span class="temp">{{ $weather[5]["temperature"] }}°C</span></li>
									<li><span class="day">{{ $weather[6]["date"] }}</span><img src="{{ $weather[6]['img'] }}" title="{{ $weather[6]['title'] }}"><span class="temp">{{ $weather[6]["temperature"] }}°C</span></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
@stop