@extends('layouts.master')

@section('title','後台管理系統-驗收單-泰達運動顧問有限公司')

@section('content')
<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">驗收單</h1>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<section class="box ">
				<header class="panel_header">
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table id="form_table" class="table table-striped dt-responsive display">
								<thead>
									<tr>
										<th>編號</th>
										<th>代碼</th>
										<th>項目</th>
										<th>場館</th>
										<th>管理人員</th>
										<th>新增時間</th>
										<th>操作</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>編號</th>
										<th>代碼</th>
										<th>項目</th>
										<th>場館</th>
										<th>管理人員</th>
										<th>新增時間</th>
										<th>操作</th>
									</tr>
								</tfoot>
								<tbody align="center">
									@foreach ($forms as $f => $form)
									<tr>
										<td>{{ $f + 1 }}</td>
										<td>{{ $form -> form_id }}</td>
										<td>{{ $form -> item_detail -> item -> name }}</td>
										<td>{{ $form -> item_detail -> location -> name }}</td>
										<td>{{ $form -> user -> name }}</td>
										<td>{{ date('Y-m-d', strtotime($form -> created_time)) }}</td>
										<td>
											@if ($form -> item_detail -> item -> name != "ALL")
											<button type="button" class="btn btn-primary" onclick="location.href='{{url('/form_detail')}}/{{ $form -> id }}';"><i class="fa fa-eye"></i></button>
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
	</section>
</section>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#form_table').DataTable();

		$("#form_table tfoot th").each( function ( i ) {
			var select = $('<select><option value=""></option></select>').appendTo($(this).empty()).on( 'change', function () {
					table.column( i ).search($(this).val()).draw();
				});

				table.column( i ).data().unique().sort().each( function ( d, j ) {
					select.append('<option value="'+d+'">'+d+'</option>')
				});
			});
		});
</script>
@stop