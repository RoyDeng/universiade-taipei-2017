@extends('layouts.master')

@section('title','後台管理系統-簽到/退表-泰達運動顧問有限公司')

@section('content')
<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">簽到/退表</h1>
					@if ($msg = Session::get('success'))
						<div class="alert alert-success alert-dismissible fade in">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<strong>{{ $msg }}</strong>
						</div>
					@endif
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
										<th>工作人員</th>
										<th>項目</th>
										<th>場館</th>
										<th>簽到時間</th>
										<th>簽退時間</th>
										<th>時數</th>
										<th>加班時數</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($logs as $l => $log)
									<tr>
										<td>{{ $l + 1 }}</td>
										<td>{{ $log -> user ->name }}</td>
										<td>{{ $log -> item_detail -> item -> name }}</td>
										<td>{{ $log -> item_detail -> location -> name }}</td>
										<td>{{ $log -> check_in_time }}</td>
										<td>{{ $log -> check_out_time }}</td>
										<td>{{ $log -> period }}</td>
										<td>{{ $log -> extra }}</td>
										<td>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editLogModal" data-toggle="modal" onclick="editLog('{{ $log -> id }}', '{{ $log -> item_detail_id }}')"><i class="fa fa-pencil-square-o"></i></button>
											@endif
											<input type="hidden" name="hidden_view_detail" id="hidden_view_detail" value="{{url('/check_log/viewLog')}}">
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

<div class="modal fade col-xs-12" id="editLogModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改記錄</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/check_log/updateLog') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_user_name">工讀生</label>
						<div class="controls">
							<input type="text" id="edit_user_name" class="form-control" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_item_name">項目</label>
						<div class="controls">
							<input type="text" id="edit_item_name" class="form-control" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_location_name">場館</label>
						<div class="controls">
							<input type="text" id="edit_location_name" class="form-control" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_check_in_time">簽到時間</label>
						<div class="controls">
							<input type="text" id="edit_check_in_time" class="form-control" name="check_in_time" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="check_out_time">簽退時間</label>
						<div class="controls">
							<input  type="text" id="edit_check_out_time" class="form-control" name="check_out_time" required>
						</div>
					</div>
					<input type="hidden" id="edit_log_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		$('#form_table').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'print', 'excel'
			]
		});
	});

	function editLog(id, item_detail_id) {
		var view_url = $("#hidden_view_detail").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"id":id, "item_detail_id":item_detail_id},
			success: function(result) {
				$("#edit_log_id").val(result.log.id);
				$("#edit_user_name").val(result.log.user.name);
				$("#edit_item_name").val(result.item_detail.item.name);
				$("#edit_location_name").val(result.item_detail.location.name);
				$("#edit_check_in_time").val(result.log.check_in_time);
				$("#edit_check_out_time").val(result.log.check_out_time);
			}
		});
	}
</script>
@stop