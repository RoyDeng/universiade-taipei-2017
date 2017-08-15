@extends('layouts.master')

@section('title','後台管理系統-驗收單-泰達運動顧問有限公司')

@section('content')
<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<button type="button" id="btn_print" class="btn btn-info"><i class="fa fa-print"></i> 列印</button>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">驗收單</h2>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table class="table table-bordered">
									<tr>
										<th scope="row">表單編號</th>
										<td colspan="3">{{ $form -> form_id }}</td>
									</tr>
									<tr>
										<th scope="row">種類</th>
										<td colspan="3">{{ $form -> item_detail -> item -> name }}</td>
									</tr>
									<tr>
										<th scope="row">場館</th>
										<td colspan="3">{{ $form -> item_detail -> location -> name }}</td>
									</tr>
									<tr>
										<th scope="row">管理人員</th>
										<td>{{ $form -> user -> name }}</td>
										<th scope="row">日期</th>
										<td>{{ date('Y-m-d', strtotime($form -> created_time)) }}</td>
									</tr>
							</table>
						</div>
						<div class="clearfix"></div>
						<div class="col-xs-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>編號</th>
										<th>品名</th>
										<th>應有數量</th>
										<th>單位</th>
										<th>數量檢核</th>
										<th>是否異常</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($eqpts as $e => $eqpt)
									<tr>
										<td>{{ $e + 1 }}</td>
										<td>{{ $eqpt -> name }}</td>
										<td>{{ $eqpt -> quantity }}</td>
										<td>{{ $eqpt -> unit }}</td>
										<td>{{ $eqpt -> check_quantity }}</td>
										<td>
											@if ($eqpt -> abnormal == '[]')
											<span class="label label-success">否</span>
											@else
											<span class="label label-danger">是</span>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">器材異常情形</h2>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>編號</th>
										<th>品名</th>
										<th>異常數量</th>
										<th>異常情形</th>
										<th>照片</th>
										<th>簽章</th>
										<th>處理情形</th>
										<th>時間</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($abns as $a => $abn)
									<tr>
										<td>{{ $a + 1 }}</td>
										<td>{{ $abn -> eqpt -> name }}</td>
										<td>{{ ((int)$abn -> eqpt -> quantity - (int)$abn -> eqpt -> check_quantity) }}</td>
										<td>{{ $abn -> remark }}</td>
										<td><img src="{{ $abn -> pic }}" width="50%"></td>
										<td><img src="{{ $abn -> signature }}" width="50%"></td>
										<td>{{ $abn -> report }}</td>
										<td>{{ $abn -> created_time }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</section>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
	$(function () {
		$("#btn_print").click(function () {
			var contents = $("#main-content").html();
			var frame = $('<iframe />');
			frame[0].name = "frame";
			frame.css({ "position": "absolute", "top": "-1000000px" });
			$("body").append(frame);
			var frameDoc = frame[0].contentWindow ? frame[0].contentWindow : frame[0].contentDocument.document ? frame[0].contentDocument.document : frame[0].contentDocument;
			frameDoc.document.open();
			frameDoc.document.write('<html><head><title>驗收單</title>');
			frameDoc.document.write('<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>');
			frameDoc.document.write('<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css"/>');
			frameDoc.document.write('<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>');
			frameDoc.document.write('</head><body>');
			frameDoc.document.write(contents);
			frameDoc.document.write('</body></html>');
			frameDoc.document.close();
			setTimeout(function () {
				window.frames["frame"].focus();
				window.frames["frame"].print();
				frame.remove();
			}, 500);
		});
	});
</script>
@stop