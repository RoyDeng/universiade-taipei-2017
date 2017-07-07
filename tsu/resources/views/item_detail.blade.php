@extends('layouts.master')

@section('title','後台管理系統-運動項目明細-泰達運動顧問有限公司')

@section('content')

<section id="main-content">
	<section class="wrapper main-wrapper row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="pull-left">
					<h1 class="title">{{ $items -> name }}</h1>
					@if (Auth::user() -> level == 1)
					<div class="row">
						<div class="col-xs-8 col-md-12">
							<button type="button" class="btn btn-success" data-target="#createItemDetailModal" data-toggle="modal"><i class="fa fa-plus"></i> 新增</button>
						</div>
					</div>
					@endif
					@if ($msg = Session::get('success'))
						<div class="alert alert-success alert-dismissible fade in">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							<strong>{{ $msg }}</strong>
						</div>
					@endif
					@if ($msg = Session::get('warning'))
						<div class="alert alert-warning alert-dismissible fade in">
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
					<h2 class="title pull-left">場館</h2>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<table id="example-1" class="table table-striped dt-responsive display">
								<thead>
									<tr>
										<th>編號</th>
										<th>代碼</th>
										<th>場館</th>
										<th>新增時間</th>
										<th>修改時間</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach ($items -> item_detail as $i => $item)
									<tr>
										<td>{{ $i + 1 }}</td>
										<td>{{ $item -> abbr }}</td>
										<td>{{ $item -> location -> name }}</td>
										<td>{{ $item -> created_time }}</td>
										<td>{{ $item -> updated_time }}</td>
										<td>
											@if (Auth::user() -> level == 1)
											<button type="button" class="btn btn-info" data-target="#editItemDetailModal" data-toggle="modal" onclick="editItemDetail('{{ $item -> item_id }}', '{{ $item -> location_id }}')"><i class="fa fa-pencil-square-o"></i></button>
											@if ($item -> id != 71)
											<button type="button" class="btn btn-danger" data-target="#removeItemDetailModal" data-toggle="modal" onclick="editItemDetail('{{ $item -> item_id }}', '{{ $item -> location_id }}')"><i class="fa fa-trash"></i></button>
											@endif
											@endif
											<input type="hidden" name="hidden_view_detail" id="hidden_view_detail" value="{{url('/item/viewItemDetail')}}">
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

<div class="modal fade col-xs-12" id="createItemDetailModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">新增項目明細</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/item/createItemDetail') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="create_abbr">代碼</label>
						<div class="controls">
							<input type="text" id="create_abbr" class="form-control" name="abbr" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="create_location">場館</label>
						<div class="controls">
							<select id="create_location" class="form-control" name="location_id" required>
								<option selected>請選擇</option>
								@foreach($locations as $location)
								<option value="{{ $location -> id }}">{{ $location -> name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<input type="hidden" name="user_id" value="{{ Auth::user() -> id }}">
					<input type="hidden" name="item_id" value="{{ $items -> id }}">
					<button type="submit" class="btn btn-success">新增</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="editItemDetailModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">修改項目明細</h4>
			</div>
			<div class="modal-body">
				<form action="{{ url('/item/updateItemDetail') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="form-label" for="edit_abbr">代碼</label>
						<div class="controls">
							<input type="text" id="edit_abbr" class="form-control" name="abbr" required>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_location">目前場館</label>
						<div class="controls">
							<input type="text" id="edit_location_name" class="form-control" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="edit_location">場館</label>
						<div class="controls">
							<select id="edit_location" class="form-control" name="location_id">
								<option value="" selected>請選擇</option>
								@foreach($locations as $location)
								<option value="{{ $location -> id }}">{{ $location -> name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<input type="hidden" id="edit_item_detail_id" name="id">
					<button type="submit" class="btn btn-success">修改</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-xs-12" id="removeItemDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">刪除項目明細</h4>
			</div>
			<div class="modal-body">
				<i class="fa fa-question-circle fa-lg"></i>  
				您確定要刪除此項目明細？
				<form action="{{ url('/item/removeItemDetail') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" id="remove_item_detail_id" name="id">
					<button type="submit" class="btn btn-danger">刪除</button>
				</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function editItemDetail(item_id, location_id) {
		var view_url = $("#hidden_view_detail").val();

		$.ajax({
			url: view_url,
			type:"GET",
			data: {"item_id":item_id, "location_id":location_id},
			success: function(result) {
				$("#edit_abbr").val(result.abbr);
				$("#edit_item_detail_id").val(result.id);
				$("#edit_location_name").val(result.location.name);
				$("#remove_item_detail_id").val(result.id);
			}
		});
	}
</script>
@stop